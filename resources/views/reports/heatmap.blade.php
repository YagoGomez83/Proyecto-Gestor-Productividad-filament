@extends('layouts.app')

@section('title', 'Mapa de Calor de Reportes')

@section('content')
<div class="container mx-auto p-4 sm:p-6 lg:p-8">
    <header class="mb-6">
        <h2 class="text-3xl font-bold text-slate-800">Mapa de Calor de Reportes</h2>
        <p class="text-sm text-slate-600">Visualiza la concentración de reportes según los filtros aplicados.</p>
    </header>

    <form action="{{ route('heatmap.index') }}" method="GET" class="bg-white shadow-xl rounded-lg p-6 mb-8">
        {{-- No necesitas @csrf para un formulario GET --}}
        <fieldset>
            <legend class="text-xl font-semibold text-slate-700 mb-4 border-b pb-2">Filtros de Búsqueda</legend>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                {{-- Columna 1: Causa y Dependencia --}}
                <div class="space-y-4">
                    <div>
                        <label for="cause_id" class="block text-sm font-medium text-slate-700 mb-1">Causa</label>
                        <select name="cause_id" id="cause_id" class="w-full border-slate-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                            <option value="">Todas las causas</option>
                            @foreach($causes as $cause)
                                <option value="{{ $cause->id }}" {{ request('cause_id') == $cause->id ? 'selected' : '' }}>
                                    {{ $cause->cause_name }} {{-- Asumiendo cause_name --}}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="police_station_id" class="block text-sm font-medium text-slate-700 mb-1">Dependencia Policial</label>
                        <select name="police_station_id" id="police_station_id" class="w-full border-slate-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                            <option value="">Todas las dependencias</option>
                            @foreach($policeStations as $station) {{-- Usando $policeStations --}}
                                <option value="{{ $station->id }}" {{ request('police_station_id') == $station->id ? 'selected' : '' }}>
                                    {{ $station->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Columna 2: Fecha y Hora de Inicio --}}
                <div class="space-y-4">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-slate-700 mb-1">Fecha de Inicio</label>
                        <input type="date" name="start_date" id="start_date" class="w-full border-slate-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" value="{{ request('start_date') }}" />
                    </div>
                    <div>
                        <label for="start_time" class="block text-sm font-medium text-slate-700 mb-1">Hora de Inicio</label>
                        <input type="time" name="start_time" id="start_time" class="w-full border-slate-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" value="{{ request('start_time') }}" />
                    </div>
                </div>

                {{-- Columna 3: Fecha y Hora de Fin --}}
                <div class="space-y-4">
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-slate-700 mb-1">Fecha de Fin</label>
                        <input type="date" name="end_date" id="end_date" class="w-full border-slate-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" value="{{ request('end_date') }}" />
                    </div>
                    <div>
                        <label for="end_time" class="block text-sm font-medium text-slate-700 mb-1">Hora de Fin</label>
                        <input type="time" name="end_time" id="end_time" class="w-full border-slate-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" value="{{ request('end_time') }}" />
                    </div>
                </div>
            </div>

            <div class="mt-6 pt-4 border-t flex justify-end space-x-3">
                 <a href="{{ route('heatmap.index') }}" class="px-4 py-2 bg-slate-200 text-slate-700 font-medium rounded-md shadow-sm hover:bg-slate-300 focus:ring-2 focus:ring-slate-400 focus:ring-offset-2 text-sm">
                    Limpiar Filtros
                </a>
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white font-medium rounded-md shadow-sm hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 inline-block mr-1">
                        <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z" clip-rule="evenodd" />
                    </svg>
                    Aplicar Filtros
                </button>
            </div>
        </fieldset>
    </form>

    <div id="map" class="w-full h-[600px] rounded-lg shadow-xl border border-slate-200"></div>
    {{-- Ajuste: Aumenté la altura a h-[600px] y añadí un borde --}}
</div>

@endsection

@push('styles')
{{-- Si gestionas Leaflet CSS vía app.js (Vite), esta línea ya no es necesaria aquí. --}}
{{-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" /> --}}
<style>
    /* Estilos adicionales para el mapa si son necesarios */
    #map { background-color: #f0f4f8; } /* Un color de fondo mientras carga */
</style>
@endpush

@push('scripts')
{{-- Si gestionas Leaflet y Leaflet.heat vía app.js (Vite), estas líneas ya no son necesarias aquí. --}}
{{-- <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script> --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.heat/0.2.0/leaflet-heat.js"></script> --}}

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Espera a que L (Leaflet) esté disponible (cargado por app.js)
    function initializeMapWhenReady() {
        if (typeof L === 'undefined' || typeof L.heatLayer === 'undefined') {
            console.warn("Leaflet o Leaflet.heat no está listo todavía, reintentando...");
            setTimeout(initializeMapWhenReady, 200); // Reintenta después de 200ms
            return;
        }

        const defaultLat = -33.301726;
        const defaultLng = -66.337752;
        const defaultZoom = 12;

        const rawHeatData = @json($heatData ?? []); // Usar ?? [] por si $heatData es null
        const heatMapPoints = [];
        const reportMarkers = [];

        rawHeatData.forEach(point => {
            // Asumimos point es [lat, lng, intensity, report_id] o {lat: ..., lng: ..., intensity: ..., report_id: ...}
            // Tu código original usa point[0], point[1], etc. Lo mantendré así por ahora.
            // Si tu HeatmapService devuelve un array de arrays:
            if (Array.isArray(point) && point.length >= 3) { // Necesita al menos lat, lng, intensity
                const lat = parseFloat(point[0]);
                const lng = parseFloat(point[1]);
                const intensity = parseFloat(point[2]) * 5; // Multiplicador de intensidad
                const reportId = point.length >= 4 ? point[3] : null;

                if (!isNaN(lat) && !isNaN(lng) && !isNaN(intensity)) {
                    heatMapPoints.push([lat, lng, intensity]);
                    if (reportId) {
                        reportMarkers.push({ lat: lat, lng: lng, id: reportId });
                    }
                }
            }
            // Si tu HeatmapService devuelve un array de objetos (más robusto):
            // else if (typeof point === 'object' && point !== null && point.hasOwnProperty('latitude') && point.hasOwnProperty('longitude') && point.hasOwnProperty('intensity')) {
            //     const lat = parseFloat(point.latitude);
            //     const lng = parseFloat(point.longitude);
            //     const intensity = parseFloat(point.intensity) * 5;
            //     const reportId = point.report_id || null;

            //     if (!isNaN(lat) && !isNaN(lng) && !isNaN(intensity)) {
            //         heatMapPoints.push([lat, lng, intensity]);
            //         if (reportId) {
            //             reportMarkers.push({ lat: lat, lng: lng, id: reportId });
            //         }
            //     }
            // }
        });

        let centerLat = defaultLat;
        let centerLng = defaultLng;
        let zoomLevel = defaultZoom;

        if (heatMapPoints.length > 0) {
            // Centrar el mapa basado en los puntos, o usar el primer punto
            // Para un mejor centrado, podrías calcular el centroide de todos los puntos
            centerLat = heatMapPoints[0][0];
            centerLng = heatMapPoints[0][1];
            // Podrías ajustar el zoom si solo hay un punto o muy pocos
            if (heatMapPoints.length === 1) {
                zoomLevel = 15; // Zoom más cercano para un solo punto
            }
        }

        const map = L.map('map').setView([centerLat, centerLng], zoomLevel);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
        }).addTo(map);
        
        // Capa de calor
        if (heatMapPoints.length > 0) {
            L.heatLayer(heatMapPoints, {
                radius: 25,
                blur: 15,
                maxZoom: 18,
                minOpacity: 0.4,
                gradient: {0.4: 'blue', 0.65: 'lime', 1: 'red'} // Ejemplo de gradiente
            }).addTo(map);
        } else {
            console.warn("No se encontraron datos válidos para el mapa de calor.");
            // Opcional: Mostrar un mensaje en el mapa
            L.marker([defaultLat, defaultLng]).addTo(map)
             .bindPopup('No hay datos de reportes para mostrar con los filtros actuales.')
             .openPopup();
        }

        // Marcadores individuales (si los quieres además del heatmap)
        // Tu código original creaba circleMarkers para cada punto.
        // Esto puede ser útil si quieres clics individuales.
        reportMarkers.forEach(data => {
            const marker = L.circleMarker([data.lat, data.lng], {
                radius: 8, // Más pequeño para no saturar si hay muchos
                color: 'rgba(0, 0, 0, 0.6)',
                weight: 1,
                fillColor: '#e63946', // Un rojo distintivo
                fillOpacity: 0.7
            }).addTo(map);

            marker.bindPopup(
                `<b>Reporte ID: ${data.id}</b><br><a href="/admin/report/${data.id}" target="_blank" class="text-indigo-600 hover:underline">Ver Detalles del Informe</a>`
            );
        });

    } // Fin de initializeMapWhenReady

    initializeMapWhenReady(); // Llama a la función para inicializar
});
</script>
@endpush