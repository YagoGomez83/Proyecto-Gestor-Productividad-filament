<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class BaseHeatmapController extends Controller
{
    protected $model;
    protected $filters = [];
    protected $view;
    protected $heatmapDataField = 'location';
    
    public function __invoke(Request $request)
    {
        $query = $this->model::query();
        
        // Aplicar filtros
        foreach ($this->filters as $filter => $options) {
            if ($request->has($filter)) {
                $query->where($options['field'], $request->input($filter));
            }
        }
        
        // Obtener datos para el mapa de calor
        $heatData = $query->get()->map(function($item) {
            $location = $item->{$this->heatmapDataField};
            if ($location && $location->latitude && $location->longitude) {
                return [
                    $location->latitude,
                    $location->longitude,
                    1, // Intensidad base
                    $item->id // Para el popup
                ];
            }
            return null;
        })->filter()->toArray();

        return view($this->view, [
            'heatData' => $heatData,
            // Puedes agregar aquí otros datos necesarios para los filtros
        ]);
    }
}