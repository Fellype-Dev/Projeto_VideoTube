<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = ['titulo', 'descricao', 'url', 'categoria', 'thumbnail'];

    /**
     * Extrai o ID do vídeo do YouTube a partir da URL
     */
    public function getYoutubeId()
    {
        $url = $this->url;
        
        // Padrões para URLs do YouTube
        $patterns = [
            '~youtube\.com/watch\?v=([^&]+)~',
            '~youtube\.com/embed/([^/?]+)~',
            '~youtube\.com/v/([^/?]+)~',
            '~youtu\.be/([^/?]+)~',
            '~youtube\.com/watch\?.+&v=([^&]+)~'
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return $matches[1];
            }
        }

        return null;
    }

    /**
     * Retorna a URL da thumbnail do YouTube
     */
    public function getYoutubeThumbnail()
    {
        $id = $this->getYoutubeId();
        
        if ($id) {
            return "https://img.youtube.com/vi/{$id}/maxresdefault.jpg";
        }

        return null;
    }
}