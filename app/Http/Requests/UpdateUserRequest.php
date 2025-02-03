<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $this->route('id'),
            'group_id' => 'required|exists:groups,id',
            'role' => 'required|in:operator,supervisor,coordinator',
            'city_id' => 'required|exists:cities,id',
            'password' => 'nullable|string|min:8|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no puede exceder los 255 caracteres.',
            'last_name.required' => 'El apellido es obligatorio.',
            'last_name.string' => 'El apellido debe ser una cadena de texto.',
            'last_name.max' => 'El apellido no puede exceder los 255 caracteres.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.string' => 'El correo electrónico debe ser una cadena de texto.',
            'email.email' => 'Debe proporcionar un correo electrónico válido.',
            'email.max' => 'El correo electrónico no puede exceder los 255 caracteres.',
            'email.unique' => 'El correo electrónico ya está en uso.',
            'group_id.required' => 'Debe seleccionar un grupo.',
            'group_id.exists' => 'El grupo seleccionado no es válido.',
            'center_id.required' => 'Debe seleccionar un centro.',
            'center_id.exists' => 'El centro seleccionado no es válido.',
            'role.required' => 'Debe seleccionar un rol.',
            'role.in' => 'El rol seleccionado no es válido.',
            'city_id.required' => 'Debe seleccionar una ciudad.',
            'city_id.exists' => 'La ciudad seleccionada no es válida.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ];
    }
}
