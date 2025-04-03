@extends('layouts.app')

@section('title', 'Mapa de Calor por Cámaras y Servicios')

@push('styles')
    <style>
        #mapCameras {
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
        .multiselect {
            width: 100%;
        }
        /* Asegurar que el contenedor sea visible */
        .map-container {
            position: relative;
            min-height: 600px;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Mapa de Calor por Cámaras y Servicios</h1>
        <p class="text-gray-600">Visualización geográfica de servicios filtrados por cámara, status y código de desplazamiento</p>
    </div>

    <div class="filter-card">
        <form id="filterForm">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Filtro por Cámara -->
                <div class="filter-section">
                    <label for="camera" class="filter-label">Filtrar por Cámara</label>
                    <select id="camera" name="cameras[]" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 multiselect" multiple>
                        @foreach($cameras as $camera)
                            <option value="{{ $camera->id }}">{{ $camera->identifier }} - {{ $camera->location->name ?? 'Sin ubicación' }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filtro por Status -->
                <div class="filter-section">
                    <label for="status" class="filter-label">Filtrar por Status</label>
                    <select id="status" name="status[]" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 multiselect" multiple>
                        @foreach($statuses as $status)
                            <option value="{{ $status }}">{{ $status }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filtro por Código -->
                <div class="filter-section">
                    <label for="code" class="filter-label">Filtrar por Código de Desplazamiento</label>
                    <select id="code" name="codes[]" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 multiselect" multiple>
                        @foreach($codes as $code)
                            <option value="{{ $code->code }}">{{ $code->code }} - {{ $code->description }}</option>
                        @endforeach
                    </select>
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

    <div class="bg-white rounded-lg shadow-md p-4 relative map-container">
        <div class="mb-4 flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-700">Distribución Geográfica de Servicios</h2>
            <div class="text-sm text-gray-500">
                <span id="pointsCount">{{ count($heatmapData) }}</span> puntos mostrados
            </div>
        </div>
        <div id="mapCameras" style="height: 600px; width: 100%;"></div>
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
            <p>Los colores del mapa de calor indican la densidad de servicios: <span class="text-blue-500">baja</span> → <span class="text-yellow-500">media</span> → <span class="text-red-500">alta</span></p>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- jQuery (necesario para Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <!-- Leaflet Heatmap Plugin -->
    <script src="https://unpkg.com/leaflet.heat@0.2.0/dist/leaflet-heat.js"></script>
    
    <script>
        // Datos iniciales del mapa
        let heatmapData = @json($heatmapData);
        let mapCameras;
        let heatmapLayer;
        let defaultBounds = null;
        let mapInitialized = false;

        // Función robusta para inicializar el mapa
        function initMap() {
            console.log('Intentando inicializar mapa...');
            
            const container = document.getElementById('mapCameras');
            
            // Verificación exhaustiva del contenedor
            if (!container) {
                console.error('ERROR: El elemento #mapCameras no existe en el DOM');
                return false;
            }
            
            // Verificar dimensiones
            if (container.offsetWidth <= 0 || container.offsetHeight <= 0) {
                console.warn('El contenedor del mapa tiene dimensiones cero. Reintentando...', {
                    width: container.offsetWidth,
                    height: container.offsetHeight
                });
                
                // Forzar dimensiones
                container.style.height = '600px';
                container.style.width = '100%';
                
                // Reintentar después de un breve retraso
                setTimeout(initMap, 300);
                return false;
            }

            // Si el mapa ya está inicializado, no hacer nada
            if (mapInitialized) {
                console.log('El mapa ya está inicializado');
                return true;
            }

            try {
                // Centro inicial (promedio de las coordenadas o ubicación predeterminada)
                const centerLat = heatmapData.length > 0 ? 
                    heatmapData.reduce((sum, point) => sum + point.lat, 0) / heatmapData.length : -34.6037;
                const centerLng = heatmapData.length > 0 ? 
                    heatmapData.reduce((sum, point) => sum + point.lng, 0) / heatmapData.length : -58.3816;

                // Inicializar el mapa
                mapCameras = L.map('mapCameras', {
                    preferCanvas: true // Mejor rendimiento para muchos marcadores
                }).setView([centerLat, centerLng], 13);

                // Añadir capa de tiles (OpenStreetMap)
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                    maxZoom: 19
                }).addTo(mapCameras);

                // Crear capa de calor inicial
                updateHeatmap(heatmapData);
                
                // Guardar los límites iniciales
                if (heatmapData.length > 0) {
                    const points = heatmapData.map(point => [point.lat, point.lng]);
                    defaultBounds = L.latLngBounds(points);
                }

                mapInitialized = true;
                console.log('Mapa inicializado correctamente');
                return true;
            } catch (error) {
                console.error('Error al inicializar el mapa:', error);
                return false;
            }
        }

        // Actualizar el mapa de calor con nuevos datos
        function updateHeatmap(data) {
            if (!mapCameras) {
                console.error('No se puede actualizar el mapa: mapCameras no está definido');
                return;
            }

            // Eliminar capa de calor existente si hay una
            if (heatmapLayer) {
                mapCameras.removeLayer(heatmapLayer);
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
                }).addTo(mapCameras);

                // Ajustar la vista para mostrar todos los puntos
                const bounds = L.latLngBounds(points.map(p => [p[0], p[1]]));
                mapCameras.fitBounds(bounds, { padding: [50, 50] });
            } else {
                // Si no hay datos, volver a la vista por defecto
                if (defaultBounds) {
                    mapCameras.fitBounds(defaultBounds, { padding: [50, 50] });
                } else {
                    mapCameras.setView([-34.6037, -58.3816], 13);
                }
                
                // Mostrar mensaje de que no hay datos
                L.popup()
                    .setLatLng(mapCameras.getCenter())
                    .setContent('No hay datos que coincidan con los filtros seleccionados')
                    .openOn(mapCameras);
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
                cameras: $('#camera').val() || [],
                status: $('#status').val() || [],
                codes: $('#code').val() || []
            };

            fetchHeatmapData(formData);
        }

        // Manejar el botón de limpiar filtros
        document.getElementById('resetFilters').addEventListener('click', function() {
            $('#camera').val(null).trigger('change');
            $('#status').val(null).trigger('change');
            $('#code').val(null).trigger('change');
            
            // Aplicar filtros vacíos para obtener todos los datos
            fetchHeatmapData({});
        });

        // Obtener datos del mapa de calor desde el servidor
        function fetchHeatmapData(filters) {
            showLoading(true);
            
            const queryParams = new URLSearchParams();
            
            if (filters.cameras && filters.cameras.length > 0) {
                filters.cameras.forEach(camera => queryParams.append('cameras[]', camera));
            }
            if (filters.status && filters.status.length > 0) {
                filters.status.forEach(status => queryParams.append('status[]', status));
            }
            if (filters.codes && filters.codes.length > 0) {
                filters.codes.forEach(code => queryParams.append('codes[]', code));
            }

            fetch(`{{ route('cameras.heatmap.data') }}?${queryParams.toString()}`, {
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
                    
                    // Mostrar mensaje de error en el mapa
                    if (mapCameras) {
                        L.popup()
                            .setLatLng(mapCameras.getCenter())
                            .setContent('Error al cargar los datos. Por favor, intente nuevamente.')
                            .openOn(mapCameras);
                    }
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

        // Inicialización cuando el DOM esté listo
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM completamente cargado');
            
            // Inicializar select2 para los multiselect
            $('.multiselect').select2({
                placeholder: 'Seleccione opciones',
                allowClear: true
            });

            // Intentar inicializar el mapa inmediatamente
            if (!initMap()) {
                // Si falla, reintentar después de un breve retraso
                setTimeout(function() {
                    console.log('Reintentando inicialización del mapa...');
                    initMap();
                }, 500);
            }
        });

        // Manejar redimensionamiento de la ventana
        window.addEventListener('resize', function() {
            if (mapCameras) {
                setTimeout(function() {
                    mapCameras.invalidateSize();
                }, 300);
            }
        });
    </script>
@endpush