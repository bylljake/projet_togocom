<?php

namespace App\Http\Requests\Auth;

use App\Http\Helpers\Helper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;


class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:users,email',
            'password' => ['required', 'min:8', 'max:50']
        ];
    }

    /**
     * Send error message
     * @return message and error code.
     */
    public function failedValidation(Validator $validator)
    {
        Helper::sendError('Email ou mot de passe invalide', $validator->errors());
    }

    /**
     * Error message
     * @return message
     */
    public function messages()
    {
        return [
            'email.required' => 'Le champ email est obligatoire.',
            'password.required' => 'Le champ mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au minimum 8 caractères.',
        ];
    }
}
