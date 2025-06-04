@extends('layouts.app')

@section('title', 'Crear Informe')

@section('content')
<h2 class="text-2xl font-bold mb-4">Crear un Nuevo Informe</h2>

@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">¡Error de validación!</strong>
        <span class="block sm:inline">Por favor, corrige los errores en el formulario.</span>
        <ul class="mt-3 list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('reports.store') }}" method="POST">
    @csrf

    <fieldset class="border border-gray-300 p-5 my-3 rounded-md bg-slate-50 shadow-sm">
        <legend class="text-lg font-semibold px-2 text-gray-700">Datos Generales del Informe</legend>
        <div class="flex flex-col md:flex-row gap-5">
            <div class="w-full md:w-1/2">
                <label for="title" class="block text-sm font-medium text-gray-700 uppercase mb-1">*Título</label>
                <input type="text" name="title" id="title"
                    class="w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white @error('title') border-red-500 @enderror"
                    value="{{ old('title') }}" required>
                @error('title')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="w-full md:w-1/2">
                <label for="description" class="block text-sm font-medium text-gray-700 uppercase mb-1">*Descripción</label>
                <textarea name="description" id="description" rows="3"
                    class="w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white @error('description') border-red-500 @enderror"
                    required>{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </fieldset>

    <fieldset class="border border-gray-300 p-5 my-3 rounded-md bg-slate-50 shadow-sm">
        <legend class="text-lg font-semibold px-2 text-gray-700">Fecha y Hora del Evento</legend>
        <div class="flex flex-col md:flex-row gap-5">
            <div class="w-full md:w-1/2">
                <label for="report_date" class="block text-sm font-medium text-gray-700 uppercase mb-1">*Fecha</label>
                <input type="date" name="report_date" id="report_date"
                    class="w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white @error('report_date') border-red-500 @enderror"
                    value="{{ old('report_date', date('Y-m-d')) }}" required>
                @error('report_date')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="w-full md:w-1/2">
                <label for="report_time" class="block text-sm font-medium text-gray-700 uppercase mb-1">*Hora</label>
                <input type="time" name="report_time" id="report_time"
                    class="w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white @error('report_time') border-red-500 @enderror"
                    value="{{ old('report_time', date('H:i')) }}" required>
                @error('report_time')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </fieldset>

    <fieldset class="border border-gray-300 p-5 my-3 rounded-md bg-slate-50 shadow-sm">
        <legend class="text-lg font-semibold px-2 text-gray-700">Detalles de Investigación</legend>
        <div class="flex flex-col lg:flex-row gap-6">
            <div class="w-full lg:w-1/3 space-y-2">
                <div>
                    <label for="cameraSearch" class="block text-sm font-medium text-gray-700 uppercase mb-1">Buscar Cámaras</label>
                    <input type="text" id="cameraSearch" class="w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white" placeholder="Escriba para filtrar cámaras...">
                </div>
                <div>
                    <label for="cameras" class="block text-sm font-medium text-gray-700 uppercase mb-1">Cámaras Disponibles</label>
                    <select id="cameras" class="w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white" multiple size="5">
                        @foreach ($cameras as $camera)
                            <option value="{{ $camera->id }}">{{ $camera->identifier }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="button" id="addCamera" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md shadow-sm text-sm font-medium">
                    Agregar Cámara(s) Seleccionada(s)
                </button>
                <div>
                    <h4 class="text-sm font-medium text-gray-700 uppercase mt-3">Cámaras Agregadas:</h4>
                    <ol id="selectedCamerasList" class="list-decimal pl-5 mt-1 bg-gray-100 p-3 rounded-md min-h-[60px] text-sm border border-gray-200"></ol>
                    <div id="hiddenCamerasContainer"></div>
                    @error('cameras') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    @error('cameras.*') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="w-full lg:w-1/3 space-y-2">
                <div>
                    <label for="policeStationSearch" class="block text-sm font-medium text-gray-700 uppercase mb-1">Buscar Dependencia</label>
                    <input type="text" id="policeStationSearch" class="w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white" placeholder="Escriba para filtrar dependencias...">
                </div>
                <div>
                    <label for="police_station_id" class="block text-sm font-medium text-gray-700 uppercase mb-1">*Dependencia</label>
                    <select name="police_station_id" id="police_station_id" class="w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white @error('police_station_id') border-red-500 @enderror" required>
                        <option value="">Seleccione una dependencia</option>
                        @foreach ($policeStations as $policeStation)
                            <option value="{{ $policeStation->id }}" {{ old('police_station_id') == $policeStation->id ? 'selected' : '' }}>{{ $policeStation->name }}</option>
                        @endforeach
                    </select>
                    @error('police_station_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="w-full lg:w-1/3 space-y-2">
                <div>
                    <label for="causeSearch" class="block text-sm font-medium text-gray-700 uppercase mb-1">Buscar Causa</label>
                    <input type="text" id="causeSearch" class="w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white" placeholder="Escriba para filtrar causas...">
                </div>
                <div>
                    <label for="cause_id" class="block text-sm font-medium text-gray-700 uppercase mb-1">*Causa</label>
                    <select name="cause_id" id="cause_id" class="w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white @error('cause_id') border-red-500 @enderror" required>
                        <option value="">Seleccione una causa</option>
                        @foreach ($causes as $cause)
                            <option value="{{ $cause->id }}" {{ old('cause_id') == $cause->id ? 'selected' : '' }}>{{ $cause->cause_name }}</option>
                        @endforeach
                    </select>
                    @error('cause_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>
    </fieldset>

    <fieldset class="border border-gray-300 p-5 my-3 rounded-md bg-slate-50 shadow-sm">
        <legend class="text-lg font-semibold px-2 text-gray-700">Involucrados</legend>
        <div class="flex flex-col lg:flex-row gap-6">
            <div class="w-full lg:w-1/3 space-y-2">
                <div>
                    <label for="victimSearch" class="block text-sm font-medium text-gray-700 uppercase mb-1">Buscar Víctimas</label>
                    <input type="text" id="victimSearch" class="w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white" placeholder="Filtrar víctimas...">
                </div>
                <div>
                    <label for="victims" class="block text-sm font-medium text-gray-700 uppercase mb-1">Víctimas Disponibles</label>
                    <select id="victims" class="w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white" multiple size="5">
                        @foreach ($victims as $victim)
                            <option value="{{ $victim->id }}">{{ $victim->name }} {{ $victim->lastName }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="button" id="addVictim" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md shadow-sm text-sm font-medium">Agregar Víctima(s)</button>
                <div>
                    <h4 class="text-sm font-medium text-gray-700 uppercase mt-3">Víctimas Agregadas:</h4>
                    <ol id="selectedVictimsList" class="list-decimal pl-5 mt-1 bg-gray-100 p-3 rounded-md min-h-[60px] text-sm border"></ol>
                    <div id="hiddenVictimsContainer"></div>
                    @error('victims') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    @error('victims.*') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="w-full lg:w-1/3 space-y-2">
                <div>
                    <label for="accusedSearch" class="block text-sm font-medium text-gray-700 uppercase mb-1">Buscar Sospechosos</label>
                    <input type="text" id="accusedSearch" class="w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white" placeholder="Filtrar sospechosos...">
                </div>
                <div>
                    <label for="accuseds" class="block text-sm font-medium text-gray-700 uppercase mb-1">Sospechosos Disponibles</label>
                    <select id="accuseds" class="w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white" multiple size="5">
                        @foreach ($accuseds as $accused)
                            <option value="{{ $accused->id }}">{{ $accused->name }} {{ $accused->lastName }} ({{ $accused->nickName }})</option>
                        @endforeach
                    </select>
                </div>
                <button type="button" id="addAccused" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md shadow-sm text-sm font-medium">Agregar Sospechoso(s)</button>
                <div>
                    <h4 class="text-sm font-medium text-gray-700 uppercase mt-3">Sospechosos Agregados:</h4>
                    <ol id="selectedAccusedsList" class="list-decimal pl-5 mt-1 bg-gray-100 p-3 rounded-md min-h-[60px] text-sm border"></ol>
                    <div id="hiddenAccusedsContainer"></div>
                    @error('accuseds') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    @error('accuseds.*') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="w-full lg:w-1/3 space-y-2">
                <div>
                    <label for="vehicleSearch" class="block text-sm font-medium text-gray-700 uppercase mb-1">Buscar Vehículos</label>
                    <input type="text" id="vehicleSearch" class="w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white" placeholder="Filtrar vehículos...">
                </div>
                <div>
                    <label for="vehicles" class="block text-sm font-medium text-gray-700 uppercase mb-1">Vehículos Disponibles</label>
                    <select id="vehicles" class="w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white" multiple size="5">
                        @foreach ($vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}">{{ $vehicle->brand }} {{ $vehicle->model }} ({{ $vehicle->plate_number }})</option>
                        @endforeach
                    </select>
                </div>
                <button type="button" id="addVehicle" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md shadow-sm text-sm font-medium">Agregar Vehículo(s)</button>
                <div>
                    <h4 class="text-sm font-medium text-gray-700 uppercase mt-3">Vehículos Agregados:</h4>
                    <ol id="selectedVehiclesList" class="list-decimal pl-5 mt-1 bg-gray-100 p-3 rounded-md min-h-[60px] text-sm border"></ol>
                    <div id="hiddenVehiclesContainer"></div>
                    @error('vehicles') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    @error('vehicles.*') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>
    </fieldset>

    <fieldset class="border border-gray-300 p-5 my-3 rounded-md bg-slate-50 shadow-sm">
        <legend class="text-lg font-semibold px-2 text-gray-700">Ubicación del Evento</legend>
        <div class="mb-4">
            <label for="map" class="block text-sm font-medium text-gray-700 uppercase mb-1">Marcar en Mapa (Click o buscar para ubicar, o arrastrar marcador)</label>
            <div id="map" style="height: 450px; width: 100%;" class="z-0 rounded-md border border-gray-300 shadow-sm"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div>
                <label for="latitude" class="block text-sm font-medium text-gray-700 uppercase mb-1">*Latitud</label>
                <input type="text" id="latitude" name="latitude"
                    class="w-full border-gray-300 rounded-md shadow-sm p-2 bg-gray-100 @error('latitude') border-red-500 @enderror"
                    value="{{ old('latitude') }}" readonly required>
                @error('latitude') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="longitude" class="block text-sm font-medium text-gray-700 uppercase mb-1">*Longitud</label>
                <input type="text" id="longitude" name="longitude"
                    class="w-full border-gray-300 rounded-md shadow-sm p-2 bg-gray-100 @error('longitude') border-red-500 @enderror"
                    value="{{ old('longitude') }}" readonly required>
                @error('longitude') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="address" class="block text-sm font-medium text-gray-700 uppercase mb-1">*Dirección (Autocompletada)</label>
                <input type="text" id="address" name="address"
                    class="w-full border-gray-300 rounded-md shadow-sm p-2 bg-gray-100 @error('address') border-red-500 @enderror"
                    value="{{ old('address') }}" readonly required>
                @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>
    </fieldset>

    <div class="mt-6 flex justify-end">
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md shadow-sm text-base font-medium cursor-pointer">
            Guardar Informe
        </button>
    </div>
</form>
@endsection

@push('styles')
{{-- Los estilos de Leaflet y Leaflet Control Geocoder ahora vienen de app.css via Vite --}}
<style>
    .select-search-placeholder { color: #9ca3af; }
    select[multiple] { min-height: 120px; }
    #selectedCamerasList li,
    #selectedVictimsList li,
    #selectedAccusedsList li,
    #selectedVehiclesList li {
        padding: 0.25rem 0.5rem;
        margin-bottom: 0.25rem;
        background-color: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 0.25rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .remove-item-btn {
        background: none;
        border: none;
        color: #ef4444;
        cursor: pointer;
        font-weight: bold;
        padding: 0 0.25rem;
    }
    .remove-item-btn:hover { color: #dc2626; }

    /* Estilos para el Leaflet Control Geocoder (pueden necesitar ajustes) */
    .leaflet-control-geocoder-icon {
        width: 30px !important;
        height: 30px !important;
        background-size: 20px 20px !important;
        background-position: center center !important;
    }
    .leaflet-touch .leaflet-control-geocoder-icon {
        width: 34px !important;
        height: 34px !important;
    }
    .leaflet-control-geocoder-form input {
        height: 30px !important;
        padding: 0 5px !important;
        border: 1px solid #ccc !important;
    }
     .leaflet-control-geocoder-form-expanded input {
        width: 200px !important;
    }
    .leaflet-control-geocoder-alternatives a {
        display: block;
        padding: 5px 10px;
        color: #333;
        text-decoration: none;
    }
    .leaflet-control-geocoder-alternatives {
        max-height: 200px;
        overflow-y: auto;
        background-color: white;
        border: 1px solid #ccc;
        border-top: none;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
</style>
@endpush

@push('scripts')
{{-- Leaflet y Leaflet Control Geocoder JS ahora vienen de app.js via Vite --}}
<script>
document.addEventListener("DOMContentLoaded", function() {
    function initializeSelectSearch(searchInputId, selectElementId, isSimpleSelect = false) {
        const searchInput = document.getElementById(searchInputId);
        const selectElement = document.getElementById(selectElementId);

        if (!searchInput || !selectElement) {
            return;
        }

        searchInput.addEventListener("input", function() {
            const searchValue = this.value.toLowerCase().trim();
            Array.from(selectElement.options).forEach(option => {
                if (isSimpleSelect && option.value === "") {
                    option.style.display = "block";
                    if (searchValue === "") option.classList.remove('select-search-placeholder');
                    else if (!selectElement.multiple && selectElement.value === option.value) option.classList.add('select-search-placeholder');
                    return;
                }
                const optionText = option.text.toLowerCase();
                option.style.display = optionText.includes(searchValue) ? "block" : "none";
            });
        });

        if (isSimpleSelect && selectElement.options.length > 0 && selectElement.options[0].value === "") {
            if (!selectElement.multiple && selectElement.value === selectElement.options[0].value) {
                 selectElement.options[0].classList.add('select-search-placeholder');
            }
            selectElement.addEventListener('change', function() {
                if(this.value === this.options[0].value) {
                    this.options[0].classList.add('select-search-placeholder');
                } else {
                    this.options[0].classList.remove('select-search-placeholder');
                }
            });
        }
    }

    function initializeMultipleSelectHandler(
        searchInputId,
        selectElementId,
        addButtonId,
        selectedListId,
        hiddenContainerId,
        hiddenInputName,
        itemSingularName,
        initialOldValues
    ) {
        const selectElement = document.getElementById(selectElementId);
        const addButton = document.getElementById(addButtonId);
        const selectedList = document.getElementById(selectedListId);
        const hiddenContainer = document.getElementById(hiddenContainerId);
        const searchInput = document.getElementById(searchInputId);

        if (!selectElement || !addButton || !selectedList || !hiddenContainer || !searchInput) {
            return;
        }

        initializeSelectSearch(searchInputId, selectElementId, false);

        addButton.addEventListener("click", function() {
            const selectedOptions = Array.from(selectElement.selectedOptions);

            if (selectedOptions.length === 0) {
                alert(`Por favor, seleccione al menos una ${itemSingularName} para agregar.`);
                return;
            }

            selectedOptions.forEach(option => {
                const listItemId = `selected-item-${selectElementId}-${option.value}`;
                if (document.getElementById(listItemId)) {
                    return;
                }

                const listItem = document.createElement("li");
                listItem.id = listItemId;
                listItem.textContent = option.text;

                const removeButton = document.createElement("button");
                removeButton.innerHTML = "&times;";
                removeButton.type = "button";
                removeButton.className = "remove-item-btn";
                removeButton.setAttribute('aria-label', `Quitar ${option.text}`);
                removeButton.title = `Quitar ${option.text}`;

                removeButton.addEventListener("click", function() {
                    listItem.remove();
                    const hiddenInputToRemove = document.getElementById(`hidden-input-${selectElementId}-${option.value}`);
                    if (hiddenInputToRemove) hiddenInputToRemove.remove();
                    option.disabled = false;
                    option.selected = false;
                });

                listItem.appendChild(removeButton);
                selectedList.appendChild(listItem);

                const hiddenInput = document.createElement("input");
                hiddenInput.type = "hidden";
                hiddenInput.name = hiddenInputName;
                hiddenInput.value = option.value;
                hiddenInput.id = `hidden-input-${selectElementId}-${option.value}`;
                hiddenContainer.appendChild(hiddenInput);

                option.disabled = true;
                option.selected = false;
            });

            searchInput.value = '';
            searchInput.dispatchEvent(new Event('input'));
        });

        const oldValues = initialOldValues || [];
        if (Array.isArray(oldValues) && oldValues.length > 0) {
            Array.from(selectElement.options).forEach(option => {
                if (oldValues.includes(option.value)) {
                    if (!document.getElementById(`selected-item-${selectElementId}-${option.value}`)) {
                        option.selected = true;
                        addButton.click();
                    }
                }
            });
        }
    }

    initializeMultipleSelectHandler( "cameraSearch", "cameras", "addCamera", "selectedCamerasList", "hiddenCamerasContainer", "cameras[]", "cámara", {!! json_encode(old('cameras')) !!} );
    initializeMultipleSelectHandler( "victimSearch", "victims", "addVictim", "selectedVictimsList", "hiddenVictimsContainer", "victims[]", "víctima", {!! json_encode(old('victims')) !!} );
    initializeMultipleSelectHandler( "accusedSearch", "accuseds", "addAccused", "selectedAccusedsList", "hiddenAccusedsContainer", "accuseds[]", "sospechoso", {!! json_encode(old('accuseds')) !!} );
    initializeMultipleSelectHandler( "vehicleSearch", "vehicles", "addVehicle", "selectedVehiclesList", "hiddenVehiclesContainer", "vehicles[]", "vehículo", {!! json_encode(old('vehicles')) !!} );

    initializeSelectSearch("policeStationSearch", "police_station_id", true);
    initializeSelectSearch("causeSearch", "cause_id", true);

    const mapElement = document.getElementById('map');
    if (mapElement && typeof L !== 'undefined') { // Asegurarse que L (Leaflet) esté definido
        let defaultLat = parseFloat("{{ config('leaflet.map_center_latitude', -33.2951) }}");
        let defaultLng = parseFloat("{{ config('leaflet.map_center_longitude', -66.3379) }}");
        let defaultZoom = parseInt("{{ config('leaflet.zoom_level', 14) }}");

        let initialLat = parseFloat("{{ old('latitude') }}") || defaultLat;
        let initialLng = parseFloat("{{ old('longitude') }}") || defaultLng;

        const map = L.map('map').setView([initialLat, initialLng], defaultZoom);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        let marker = L.marker([initialLat, initialLng], { draggable: true }).addTo(map);

        const latitudeInput = document.getElementById('latitude');
        const longitudeInput = document.getElementById('longitude');
        const addressInput = document.getElementById('address');

        function updateMarkerAndFieldsFromGeocode(latlng, addressName) {
            if (latitudeInput) latitudeInput.value = latlng.lat.toFixed(6);
            if (longitudeInput) longitudeInput.value = latlng.lng.toFixed(6);
            if (addressInput) addressInput.value = addressName;
            if (marker) {
                marker.setLatLng(latlng);
                marker.bindPopup(addressName).openPopup();
            }
        }
        
        function updateMapFieldsFromManual(latlng) {
            if (latitudeInput) latitudeInput.value = latlng.lat.toFixed(6);
            if (longitudeInput) longitudeInput.value = latlng.lng.toFixed(6);
            reverseGeocode(latlng.lat, latlng.lng, marker, addressInput);
        }

        if (typeof L.Control.Geocoder !== 'undefined') {
            L.Control.geocoder({
                geocoder: L.Control.Geocoder.nominatim(),
                defaultMarkGeocode: false,
                placeholder: 'Buscar dirección...',
                errorMessage: 'Dirección no encontrada.',
                showResultIcons: true,
                collapsed: true,
                position: 'topright'
            })
            .on('markgeocode', function(e) {
                const latlng = e.geocode.center;
                const name = e.geocode.name;
                map.setView(latlng, defaultZoom + 2 > 18 ? 18 : defaultZoom + 2);
                updateMarkerAndFieldsFromGeocode(latlng, name);
            })
            .addTo(map);
        } else {
            console.warn("Leaflet Control Geocoder no está cargado (L.Control.Geocoder es undefined). El buscador de direcciones no estará disponible.");
        }


        if (latitudeInput && longitudeInput && "{{ old('latitude') }}") {
            latitudeInput.value = initialLat.toFixed(6);
            longitudeInput.value = initialLng.toFixed(6);
            if (addressInput && "{{ old('address') }}") {
                addressInput.value = "{{ old('address') }}";
                marker.bindPopup("{{ old('address') }}").openPopup();
            } else {
                updateMapFieldsFromManual({ lat: initialLat, lng: initialLng });
            }
        } else {
             updateMapFieldsFromManual({ lat: initialLat, lng: initialLng });
        }

        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            updateMapFieldsFromManual(e.latlng);
        });

        marker.on('dragend', function(e) {
            updateMapFieldsFromManual(e.target.getLatLng());
        });
    } else if (!mapElement) {
        console.warn("Elemento del mapa no encontrado.");
    } else if (typeof L === 'undefined') {
        console.error("Leaflet (L) no está definido. Asegúrate de que se importe correctamente en app.js y que app.js se cargue.");
    }


    function reverseGeocode(lat, lng, markerInstance, addrInput) {
        if (!addrInput) return;
        addrInput.value = 'Buscando dirección...';

        fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}&accept-language=es`)
            .then(response => {
                if (!response.ok) throw new Error(`Error de red: ${response.statusText}`);
                return response.json();
            })
            .then(data => {
                if (data && data.display_name) {
                    addrInput.value = data.display_name;
                    if (markerInstance) markerInstance.bindPopup(data.display_name).openPopup();
                } else {
                    addrInput.value = 'Dirección no encontrada';
                    if (markerInstance) markerInstance.bindPopup('Dirección no encontrada').openPopup();
                }
            })
            .catch(error => {
                console.error('Error en geocodificación inversa:', error);
                addrInput.value = 'Error al obtener dirección';
            });
    }
});
</script>
@endpush