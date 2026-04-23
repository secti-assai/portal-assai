<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PerguntarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'mensagem' => [
                'required',
                'string',
                'max:1000',
                'min:2',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'mensagem.required' => 'O campo mensagem é obrigatório',
            'mensagem.string' => 'A mensagem deve ser um texto',
            'mensagem.max' => 'A mensagem não pode ter mais de 1000 caracteres',
            'mensagem.min' => 'A mensagem deve ter pelo menos 2 caracteres',
        ];
    }
}
