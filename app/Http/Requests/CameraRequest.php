<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CameraRequest extends FormRequest
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
            'identifier' => 'required|string|max:255',

            'city_id' => 'required|exists:cities,id',
            'police_station_id' => 'required|exists:police_stations,id',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'address' => 'required|string|max:255',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'identifier.required' => 'El identificador es requerido.',
            'identifier.string' => 'El identificador debe ser una cadena de texto.',
            'identifier.max' => 'El identificador no debe superar los 255 caracteres.',



            'city_id.required' => 'La ciudad es requerida.',
            'city_id.exists' => 'La ciudad seleccionada no es válida.',

            'police_station_id.required' => 'La estación de policía es requerida.',
            'police_station_id.exists' => 'La estación de policía seleccionada no es válida.',

            'latitude.required' => 'La latitud es requerida.',
            'latitude.numeric' => 'La latitud debe ser un número.',
            'latitude.between' => 'La latitud debe estar entre -90 y 90.',

            'longitude.required' => 'La longitud es requerida.',
            'longitude.numeric' => 'La longitud debe ser un número.',
            'longitude.between' => 'La longitud debe estar entre -180 y 180.',

            'address.required' => 'La dirección es requerida.',
            'address.string' => 'La dirección debe ser una cadena de texto.',
            'address.max' => 'La dirección no debe superar los 255 caracteres.',
        ];
    }
}
