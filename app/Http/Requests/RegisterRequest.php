<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules()
    {
        return [
            'name'      => ['required', 'string'],
            'email'     => ['required', 'string', 'email:dns'],
            'password'  => ['required', 'string', 'min:8'],
            'phone'     => ['required', 'string', 'regex:/^\d{13}$/'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return void
     */
    public function messages()
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O campo nome deve ser uma string.',
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.string' => 'O campo e-mail deve ser uma string.',
            'email.email' => 'O campo e-mail deve ser um e-mail válido.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.string' => 'O campo senha deve ser uma string.',
            'password.min' => 'O campo senha deve ter no mínimo 8 caracteres.',
            'phone.required' => 'O campo telefone é obrigatório.',
            'phone.string' => 'O campo telefone deve ser uma string.',
            'phone.integer' => 'O campo telefone deve ser um número inteiro.',
            'phone.size' => 'O campo telefone deve ter 13 caracteres.',
        ];
    }
}
