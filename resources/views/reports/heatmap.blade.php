@extends('layouts.app')

@section('title', 'Mapa de Calor de Reportes y Servicios')

@push('styles')
    <style>
        /* Tus estilos existentes... */
        
        /* Nuevos estilos para el selector de tipo de mapa */
        .map-type-selector {
            margin-bottom: 20px;
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        .map-type-option {
            display: inline-block;
            margin-right: 10px;
        }
    </style>
@endpush

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Mapa de Calor de Reportes y Servicios</h1>
        <p class="text-gray-600">Visualización geográfica de la concentración de incidentes y servicios policiales</p>
    </div>

    <!-- Selector de tipo de mapa -->
    <div class="map-type-selector">
        <label for="mapTypeSelector" class="filter-label">Tipo de Mapa:</label>
        <select id="mapTypeSelector" class="form-select">
            <option value="reports">Reportes</option>
            <option value="services">Servicios</option>
        </select>
    </div>

    <!-- Filtros de Reportes (visible por defecto) -->
    <div id="reportFilters">
        @include('reports.partials.heatmap-report-filters')
    </div>

    <!-- Filtros de Servicios (oculto inicialmente) -->
    <div id="serviceFilters" style="display: none;">
        @include('reports.partials.heatmap-service-filters')
    </div>

    <!-- Mapa -->
    <div class="bg-white rounded-lg shadow-md p-4 relative">
        <div class="mb-4 flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-700">Distribución Geográfica</h2>
            <div class="text-sm text-gray-500">
                <span id="pointsCount">{{ count($heatmapData) + count($serviceHeatmapData) }}</span> puntos mostrados
            </div>
        </div>
        <div id="mapReports"></div>
        <div class="loading-spinner" id="loadingSpinner">
            <!-- Tu spinner existente -->
        </div>
        <div class="mt-4 text-xs text-gray-500">
            <p>Leyenda: 
                <span class="text-blue-500">Reportes</span> | 
                <span class="text-purple-500">Servicios</span>
            </p>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const heatmapData = @json($heatmapData ?? []);
            const serviceHeatmapData = @json($serviceHeatmapData ?? []);
            const route = '{{ route('reports.heatmap.data') }}';
            
            window.initializeHeatmap(heatmapData, serviceHeatmapData, route);
        });
    </script>
@endpush