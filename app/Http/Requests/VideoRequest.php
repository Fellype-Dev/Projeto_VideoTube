<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'url' => ['required', 'url'],
            'categoria' => ['nullable', 'string', 'max:50'],
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required' => 'O título é obrigatório.',
            'titulo.max' => 'O título deve ter no máximo 150 caracteres.',
            'url.required' => 'A URL do vídeo é obrigatória.',
            'url.url' => 'A URL deve ser válida.',
            'categoria.max' => 'A categoria deve ter no máximo 50 caracteres.',
        ];
    }
}
