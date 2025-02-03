<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determinar si el usuario está autorizado para realizar esta solicitud.
     */
    public function authorize(): bool
    {
        return true; // Cambia esto si necesitas autorización adicional
    }

    /**
     * Reglas de validación para la solicitud.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'group_id' => 'required|exists:groups,id',
            'role' => 'required|in:operator,supervisor,coordinator',
            'city_id' => 'required|exists:cities,id',
            'address' => 'required|string',
            'phone_number' => 'required|string',
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|string|min:8|same:password',
        ];
    }

    /**
     * Mensajes personalizados para las reglas de validación.
     */
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
            'role.required' => 'Debe seleccionar un rol.',
            'role.in' => 'El rol seleccionado no es válido.',
            'city_id.required' => 'Debe seleccionar una ciudad.',
            'city_id.exists' => 'La ciudad seleccionada no es válida.',
            'address.required' => 'La dirección es obligatoria.',
            'address.string' => 'La dirección debe ser una cadena de texto.',
            'phone_number.required' => 'El número de teléfono es obligatorio.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min_length' => 'La contraseña debe tener al menos 8 caracteres.',
            'password_confirmation.required' => 'La confirmación de la contraseña es obligatoria.',
            'password_confirmation.min_length' => 'La confirmación de la contraseña debe tener al menos 8 caracteres.',
            'password_confirmation.same' => 'Las contraseñas no coinciden.',
        ];
    }
}
