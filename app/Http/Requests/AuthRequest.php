<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', 'string', 'email:dns'],
            'password' => ['required', 'string', 'min:8'],
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
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.string' => 'O campo e-mail deve ser uma string.',
            'email.email' => 'O campo e-mail deve ser um e-mail válido.',
            'password.required' => 'O campo nome é obrigatório.',
            'password.string' => 'O campo nome deve ser uma string.',
        ];
    }
}
