@extends('layouts.app')

@section('title', 'Mapa de Calor de Reportes')

@push('styles')
    {{-- <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- Leaflet Heatmap Plugin -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet.heat@0.2.0/dist/leaflet-heat.css" /> --}}
    <style>
        #map {
            height: 600px;
            width: 100%;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .filter-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        .leaflet-container {
            background: #f8fafc !important;
        }
        .filter-section {
            margin-bottom: 1.5rem;
        }
        .filter-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #374151;
        }
        .loading-spinner {
            display: none;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
            background: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
@endpush

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Mapa de Calor de Reportes</h1>
        <p class="text-gray-600">Visualización geográfica de la concentración de incidentes reportados</p>
    </div>

    <div class="filter-card">
        <form id="filterForm">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Filtro por Causa -->
                <div class="filter-section">
                    <label for="cause" class="filter-label">Filtrar por Causa</label>
                    <select id="cause" name="cause" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Todas las causas</option>
                        @foreach($causes as $cause)
                            <option value="{{ $cause->id }}">{{ $cause->cause_name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filtro por Fecha -->
                <div class="filter-section">
                    <label for="date" class="filter-label">Filtrar por Fecha</label>
                    <input type="date" id="date" name="date" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Filtro por Rango de Horas -->
                <div class="filter-section">
                    <label for="timeRange" class="filter-label">Rango de Horas: <span id="timeRangeValue">00:00 - 23:59</span></label>
                    <div class="flex items-center space-x-4 mt-2">
                        <input type="time" id="startTime" name="startTime" value="00:00" class="w-1/3 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <span class="text-gray-500">a</span>
                        <input type="time" id="endTime" name="endTime" value="23:59" class="w-1/3 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <button type="reset" id="resetFilters" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors">
                    Limpiar Filtros
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                    Aplicar Filtros
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow-md p-4 relative">
        <div class="mb-4 flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-700">Distribución Geográfica de Incidentes</h2>
            <div class="text-sm text-gray-500">
                <span id="pointsCount">{{ count($heatmapData) }}</span> puntos mostrados
            </div>
        </div>
        <div id="map"></div>
        <div class="loading-spinner" id="loadingSpinner">
            <div class="flex items-center">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Cargando datos...</span>
            </div>
        </div>
        <div class="mt-4 text-xs text-gray-500">
            <p>Los colores del mapa de calor indican la densidad de reportes: <span class="text-blue-500">baja</span> → <span class="text-yellow-500">media</span> → <span class="text-red-500">alta</span></p>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <!-- Leaflet Heatmap Plugin -->
    <script src="https://unpkg.com/leaflet.heat@0.2.0/dist/leaflet-heat.js"></script>
    
    <script>
        // Datos iniciales del mapa
        let heatmapData = @json($heatmapData);
        let map;
        let heatmapLayer;
        let defaultBounds = null;

        // Inicializar el mapa
        function initMap() {
            // Centro inicial (promedio de las coordenadas o ubicación predeterminada)
            const centerLat = heatmapData.length > 0 ? 
                heatmapData.reduce((sum, point) => sum + point.lat, 0) / heatmapData.length : -34.6037;
            const centerLng = heatmapData.length > 0 ? 
                heatmapData.reduce((sum, point) => sum + point.lng, 0) / heatmapData.length : -58.3816;

            map = L.map('map').setView([centerLat, centerLng], 13);

            // Añadir capa de tiles (OpenStreetMap)
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                maxZoom: 19
            }).addTo(map);

            // Crear capa de calor inicial
            updateHeatmap(heatmapData);
            
            // Guardar los límites iniciales
            if (heatmapData.length > 0) {
                const points = heatmapData.map(point => [point.lat, point.lng]);
                defaultBounds = L.latLngBounds(points);
            }
        }

        // Actualizar el mapa de calor con nuevos datos
        function updateHeatmap(data) {
            // Eliminar capa de calor existente si hay una
            if (heatmapLayer) {
                map.removeLayer(heatmapLayer);
            }

            // Actualizar contador de puntos
            document.getElementById('pointsCount').textContent = data.length;

            // Crear nueva capa de calor si hay datos
            if (data.length > 0) {
                const points = data.map(point => [point.lat, point.lng, point.intensity || 1]);
                heatmapLayer = L.heatLayer(points, {
                    radius: 25,
                    blur: 15,
                    maxZoom: 17,
                    minOpacity: 0.5,
                    gradient: {
                        0.4: 'blue',
                        0.6: 'cyan',
                        0.7: 'lime',
                        0.8: 'yellow',
                        1.0: 'red'
                    }
                }).addTo(map);

                // Ajustar la vista para mostrar todos los puntos
                const bounds = L.latLngBounds(points.map(p => [p[0], p[1]]));
                map.fitBounds(bounds);
            } else {
                // Si no hay datos, volver a la vista por defecto
                if (defaultBounds) {
                    map.fitBounds(defaultBounds);
                } else {
                    map.setView([-34.6037, -58.3816], 13);
                }
                
                // Mostrar mensaje de que no hay datos
                L.popup()
                    .setLatLng(map.getCenter())
                    .setContent('No hay datos que coincidan con los filtros seleccionados')
                    .openOn(map);
            }
        }

        // Manejar el envío del formulario de filtros
        document.getElementById('filterForm').addEventListener('submit', function(e) {
            e.preventDefault();
            applyFilters();
        });

        // Aplicar filtros
        function applyFilters() {
            const formData = {
                cause: document.getElementById('cause').value,
                date: document.getElementById('date').value,
                startTime: document.getElementById('startTime').value,
                endTime: document.getElementById('endTime').value
            };

            fetchHeatmapData(formData);
        }

        // Manejar el botón de limpiar filtros
        document.getElementById('resetFilters').addEventListener('click', function() {
            document.getElementById('cause').value = '';
            document.getElementById('date').value = '';
            document.getElementById('startTime').value = '00:00';
            document.getElementById('endTime').value = '23:59';
            document.getElementById('timeRangeValue').textContent = '00:00 - 23:59';
            
            // Aplicar filtros vacíos para obtener todos los datos
            fetchHeatmapData({});
        });

        // Actualizar la visualización del rango de horas
        document.getElementById('startTime').addEventListener('change', updateTimeRangeDisplay);
        document.getElementById('endTime').addEventListener('change', updateTimeRangeDisplay);

        function updateTimeRangeDisplay() {
            const startTime = document.getElementById('startTime').value;
            const endTime = document.getElementById('endTime').value;
            document.getElementById('timeRangeValue').textContent = `${startTime} - ${endTime}`;
        }

        // Obtener datos del mapa de calor desde el servidor
        function fetchHeatmapData(filters) {
            showLoading(true);
            
            const queryParams = new URLSearchParams();
            
            if (filters.cause) queryParams.append('cause', filters.cause);
            if (filters.date) queryParams.append('date', filters.date);
            if (filters.startTime) queryParams.append('start_time', filters.startTime);
            if (filters.endTime) queryParams.append('end_time', filters.endTime);

            fetch(`{{ route('reports.heatmap.data') }}?${queryParams.toString()}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la respuesta del servidor');
                    }
                    return response.json();
                })
                .then(data => {
                    heatmapData = data;
                    updateHeatmap(data);
                    showLoading(false);
                })
                .catch(error => {
                    console.error('Error fetching heatmap data:', error);
                    showLoading(false);
                    alert('Ocurrió un error al cargar los datos. Por favor, intente nuevamente.');
                });
        }

        // Mostrar/ocultar indicador de carga
        function showLoading(show) {
            const loadingSpinner = document.getElementById('loadingSpinner');
            const buttons = document.querySelectorAll('#filterForm button');
            
            buttons.forEach(button => {
                button.disabled = show;
            });
            
            if (show) {
                loadingSpinner.style.display = 'block';
            } else {
                loadingSpinner.style.display = 'none';
            }
        }

        // Inicializar el mapa cuando el DOM esté listo
        document.addEventListener('DOMContentLoaded', initMap);
    </script>
@endpush