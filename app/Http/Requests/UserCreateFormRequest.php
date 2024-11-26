<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateFormRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'names' => 'required|string|max:255',
            'lastnames' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:8|confirmed',
            'address' => 'nullable|string|max:255',
            'role' => 'required|exists:roles,id', 
        ];
    }

    public function messages()
    {
        return [
            'names.required' => 'El nombre es obligatorio.',
            'lastnames.required' => 'El apellido es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser válido.',
            'email.unique' => 'El correo electrónico ya está en uso.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'role.confirmed' => 'Rol necesario.',
        ];
    }

    public function attributes()
    {
        return [
            'names' => 'nombre',
            'lastnames' => 'apellido',
            'email' => 'correo electrónico',
            'password' => 'contraseña',
            'address' => 'dirección',
            'role' => 'role',
        ];
    }

}
