<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Video;

class VideoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo' => ['required', 'string', 'max:150'],
            'descricao' => ['nullable', 'string', 'max:2048'],
            'url' => ['required', 'url', 'max:2048', 'youtube_url'], // Nova regra youtube_url
            'categoria' => ['required', 'in:' . implode(',', array_keys(Video::CATEGORIAS))],
            'thumbnail' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required' => 'O título é obrigatório.',
            'titulo.max' => 'O título deve ter no máximo 150 caracteres.',
            'url.required' => 'A URL do vídeo é obrigatória.',
            'url.url' => 'A URL deve ser válida.',
            'url.youtube_url' => 'Apenas URLs do YouTube são permitidas.', // Nova mensagem de erro
            'categoria.required' => 'A categoria é obrigatória.',
            'categoria.in' => 'Selecione uma categoria válida.',
            'url.max' => 'A URL não pode exceder 2048 caracteres.',
        ];
    }
}