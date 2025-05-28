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
            'descricao' => ['nullable', 'string'],
            'url' => ['required', 'url', 'max:2048'], // Adicionado max:2048
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
            'categoria.required' => 'A categoria é obrigatória.',
            'categoria.in' => 'Selecione uma categoria válida.',
            'url.max' => 'A URL não pode exceder 2048 caracteres.',
        ];
    }
}