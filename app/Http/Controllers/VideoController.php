<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::latest()->get();
        return view('videos.index', compact('videos'));
    }

    public function create()
    {
        return view('videos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|max:255',
            'descricao' => 'nullable',
            'url' => 'required|url|max:2048', // Adiciona validação de tamanho
            'categoria' => 'required|in:' . implode(',', array_keys(Video::CATEGORIAS)),
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Se não enviou thumbnail, tenta obter do YouTube
        if (!$request->hasFile('thumbnail')) {
            $thumbnailUrl = $this->getYoutubeThumbnail($validated['url']);

            if ($thumbnailUrl) {
                try {
                    $thumbnailContents = file_get_contents($thumbnailUrl);

                    if ($thumbnailContents) {
                        $filename = 'yt_' . md5(time()) . '.jpg';
                        $path = 'thumbnails/' . $filename;

                        Storage::disk('public')->put($path, $thumbnailContents);
                        $validated['thumbnail'] = $path;
                    }
                } catch (\Exception $e) {
                    // Logar o erro se necessário
                    \Log::error('Erro ao baixar thumbnail: ' . $e->getMessage());
                }
            }
        }
        // Upload manual da thumbnail
        elseif ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        Video::create($validated);

        return redirect()->route('videos.index')->with('success', 'Vídeo cadastrado com sucesso!');
    }
    public function show(Video $video)
    {
        // Carrega todos os vídeos (exceto o atual) para a coluna lateral
        $videos = Video::where('id', '!=', $video->id)
            ->latest()
            ->get();

        return view('videos.show', compact('video', 'videos'));
    }

    public function edit(Video $video)
    {
        return view('videos.edit', compact('video'));
    }

    public function update(Request $request, Video $video)
    {
        $validated = $request->validate([
            'titulo' => 'required|max:255',
            'descricao' => 'nullable',
            'url' => 'required|url',
            'categoria' => 'required|in:' . implode(',', array_keys(Video::CATEGORIAS)),
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if (!$request->hasFile('thumbnail') && $this->getYoutubeThumbnail($validated['url'])) {
            try {
                $thumbnailUrl = $this->getYoutubeThumbnail($validated['url']);
                $thumbnailContents = file_get_contents($thumbnailUrl);

                if ($thumbnailContents) {
                    if ($video->thumbnail) {
                        Storage::disk('public')->delete($video->thumbnail);
                    }

                    $filename = 'yt_' . time() . '.jpg';
                    Storage::disk('public')->put('thumbnails/' . $filename, $thumbnailContents);
                    $validated['thumbnail'] = 'thumbnails/' . $filename;
                }
            } catch (\Exception $e) {
                // Não faz nada, mantém a thumbnail existente ou continua sem
            }
        } elseif ($request->hasFile('thumbnail')) {
            if ($video->thumbnail) {
                Storage::disk('public')->delete($video->thumbnail);
            }
            $thumbnail = $request->file('thumbnail')->store('thumbnails', 'public');
            $validated['thumbnail'] = $thumbnail;
        }

        $video->update($validated);

        return redirect()->route('videos.index')->with('success', 'Vídeo atualizado com sucesso!');
    }

    public function destroy(Video $video)
    {
        if ($video->thumbnail) {
            Storage::disk('public')->delete($video->thumbnail);
        }
        $video->delete();

        return redirect()->route('videos.index')->with('success', 'Vídeo excluído com sucesso!');
    }

    private function getYoutubeThumbnail($url)
    {
        // Padrões para diferentes formatos de URLs do YouTube
        $patterns = [
            '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i',
            '/^([^"&?\/\s]{11})$/'
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                $videoId = $matches[1];

                // Tenta diferentes qualidades de thumbnail
                $qualities = ['maxresdefault', 'hqdefault', 'mqdefault', 'sddefault'];

                foreach ($qualities as $quality) {
                    $thumbnailUrl = "https://img.youtube.com/vi/{$videoId}/{$quality}.jpg";
                    if ($this->checkRemoteFile($thumbnailUrl)) {
                        return $thumbnailUrl;
                    }
                }

                return "https://img.youtube.com/vi/{$videoId}/default.jpg";
            }
        }

        return null;
    }

    private function checkRemoteFile($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_NOBODY, 1);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $httpCode == 200;
    }
}