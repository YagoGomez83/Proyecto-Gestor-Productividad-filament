@extends('layouts.app')

@section('title', 'Detalle del Informe')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-4">{{ $report->title }}</h2>
    
    <!-- Información básica -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div>
            <p><strong>Fecha:</strong> {{ $report->report_date->format('d/m/Y') }}</p>
            <p><strong>Hora:</strong> {{ $report->report_time->format('H:i') }}</p>
            <p><strong>Descripción:</strong> {{ $report->description }}</p>
        </div>
        <div>
            <p><strong>Ubicación:</strong> {{ $report->location->address }}</p>
            <p><strong>Causa:</strong> {{ $report->cause->cause_name }}</p>
            <p><strong>Dependencia:</strong> {{ $report->policeStation->name }}</p>
        </div>
    </div>

    <!-- Mapa -->
    <h3 class="text-xl font-bold mb-2">Ubicación en el mapa</h3>
    <div id="map" style="height: 400px; width: 100%;" class="mb-6 border border-gray-200 rounded-md"></div>

    <!-- Resto de tu contenido... -->
    <div class="mt-4">
        <a href="{{ route('reports.custom') }}" class="text-blue-600 hover:text-blue-800 hover:underline">
            ← Volver a la lista
        </a>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Verificar si Leaflet está disponible
    if (typeof L === 'undefined') {
        console.error('Leaflet no está cargado');
        return;
    }

    // Coordenadas del informe
    const lat = {{ $report->location->latitude }};
    const lng = {{ $report->location->longitude }};

    // Inicializar el mapa
    const map = L.map('map').setView([lat, lng], 15);

    // Añadir capa de OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Añadir marcador
    L.marker([lat, lng])
        .addTo(map)
        .bindPopup("<b>Ubicación del informe</b><br>" + 
                  "Lat: " + lat.toFixed(6) + "<br>" + 
                  "Lng: " + lng.toFixed(6))
        .openPopup();
});
</script>
@endpush
@endsection