<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'report_date' => 'required|date',
            'report_time' => 'required',
            'police_station_id' => 'required|exists:police_stations,id',
            'cameras' => 'required|array',
            'cameras.*' => 'exists:cameras,id',
            'latitude' => 'required|decimal:2,15',
            'longitude' => 'required|decimal:2,15',
            'address' => 'required',
            'victims' => 'nullable|array',
            'victims.*' => 'exists:victims,id',
            'vehicles' => 'nullable|array',
            'vehicles.*' => 'exists:vehicles,id',
            'accuseds' => 'nullable|array',
            'accuseds.*' => 'exists:accuseds,id',
            'cause_id' => 'required|exists:causes,id',


            //
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'El título es obligatorio',
            'description.required' => 'La descripción es obligatoria',
            'report_date.required' => 'La fecha de reporte es obligatoria',
            'report_time.required' => 'El horario de reporte es obligatorio',
            'police_station_id.required' => 'La estación policial es obligatoria',
            'cause_id.required' => 'La causa es obligatoria',
            'cameras.required' => 'Debe seleccionar al menos una cámara.',
            'latitude.required' => 'Debe seleccionar una latitud.',
            'longitude.required' => 'Debe seleccionar una longtud.',
            'cameras.*.exists' => 'La cámara seleccionada no es válida.',
            'locations.*.exists' => 'La ubicación seleccionada no es válida.',
            'victims.*.exists' => 'La víctima seleccionada no es válida.',
            'vehicles.*.exists' => 'El vehículo seleccionado no es válido.',
            'accuseds.*.exists' => 'El acusado seleccionado no es válido.',

        ];
    }
}
