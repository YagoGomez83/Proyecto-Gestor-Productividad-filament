@extends('layouts.app')

@section('title', 'Editar Informe')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md flex flex-col gap-5">
    <h2 class="text-2xl font-bold mb-4">Editar Informe</h2>
    @if ($errors->any())
        <div class="bg-red-500 text-white p-3 rounded-md">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('report.update', $report->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="flex flex-row gap-5 border-gray-300 w-full border mx-auto p-5 my-3 rounded-md bg-slate-100">
            <!-- Título -->
            <div class="w-1/2">
                <label for="title" class="block text-gray-700 font-bold uppercase">*Título</label>
                <input type="text" name="title" id="title"
                    class="w-full border border-gray-400 rounded-md p-2 bg-white" 
                    value="{{ old('title', $report->title) }}" required>
                @error('title')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <!-- Descripción -->
            <div class="w-1/2">
                <label for="description" class="block text-gray-700 font-bold uppercase">*Descripción</label>
                <textarea name="description" id="description" 
                    class="w-full border border-gray-400 rounded-md p-3 bg-white" required>{{ old('description', $report->description) }}</textarea>
                @error('description')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="flex flex-row gap-5 border-gray-300 w-full border mx-auto p-5 my-3 rounded-md bg-slate-100">
            <div class="w-1/2">
                <label for="report_date" class="block text-gray-700 font-bold uppercase">*Fecha</label>
                <input type="date" name="report_date" id="report_date"
                    class="w-full border-gray-400 rounded-md p-2 border bg-white" 
                    value="{{ old('report_date', $report->report_date->format('Y-m-d')) }}" required>
                @error('report_date')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
            </div>
            <div class="w-1/2">
                <label for="report_time" class="block text-gray-700 font-bold uppercase">*Hora</label>
                <input type="time" name="report_time" id="report_time"
                    class="w-full border-gray-400 rounded-md p-2 border bg-white" 
                    value="{{ old('report_time', $report->report_time->format('H:i')) }}" required>
                @error('report_time')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="flex flex-row gap-5 border-gray-300 w-full border mx-auto p-5 my-3 rounded-md bg-slate-100">
            <div class="w-1/3">
                <label for="cameraSearch" class="block text-gray-700 font-bold uppercase">Buscar Cámaras</label>
                <input type="text" id="cameraSearch"
                    class="w-full border-gray-400 rounded-md p-2 border bg-white mb-2" 
                    placeholder="Buscar cámara...">
            
                <label for="cameras" class="block text-gray-700 font-bold uppercase">Cámaras</label>
                <select id="cameras" class="w-full border-gray-400 rounded-md p-2 border bg-white" multiple>
                    @foreach ($cameras as $camera)
                        <option value="{{ $camera->id }}" 
                            {{ in_array($camera->id, $report->cameras->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $camera->identifier }}
                        </option>
                    @endforeach
                </select>
            
                <button type="button" id="addCamera" class="bg-green-500 text-white px-4 py-2 rounded-md mt-2">
                    Agregar Cámara
                </button>
            
                <!-- Lista de cámaras agregadas -->
                <ol id="selectedCameras" class="list-decimal pl-5 mt-3 bg-gray-100 p-3 rounded-md">
                    @foreach ($report->cameras as $camera)
                        <li id="camera-{{ $camera->id }}">
                            {{ $camera->identifier }}
                            <button type="button" class="ml-2 text-red-500" onclick="removeCamera({{ $camera->id }})">❌</button>
                        </li>
                    @endforeach
                </ol>
            
                <!-- Contenedor para los inputs ocultos de cámaras seleccionadas -->
                <div id="hiddenInputsContainer">
                    @foreach ($report->cameras as $camera)
                        <input type="hidden" name="cameras[]" value="{{ $camera->id }}" 
                            id="hidden-camera-{{ $camera->id }}">
                    @endforeach
                </div>
            </div>

            <div class="w-1/3">
                <label for="police_station_id" class="block text-gray-700 font-bold uppercase">Dependencia</label>
                <select name="police_station_id" id="police_station_id"
                    class="w-full border-gray-400 rounded-md p-2 border bg-white" required>
                    @foreach ($policeStations as $policeStation)
                        <option value="{{ $policeStation->id }}" 
                            {{ $report->police_station_id == $policeStation->id ? 'selected' : '' }}>
                            {{ $policeStation->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="w-1/3">
                <label for="cause_id" class="block text-gray-700 font-bold uppercase">Causa</label>
                <select name="cause_id" id="cause_id" class="w-full border-gray-400 rounded-md p-2 border bg-white"
                    required>
                    @foreach ($causes as $cause)
                        <option value="{{ $cause->id }}" 
                            {{ $report->cause_id == $cause->id ? 'selected' : '' }}>
                            {{ $cause->cause_name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="flex flex-row gap-5 border-gray-300 w-full border mx-auto p-5 my-3 rounded-md bg-slate-100">
            <div class="w-1/3">
                <label for="victims" class="block text-gray-700 font-bold uppercase">Víctimas</label>
                <select name="victims[]" id="victims" class="w-full border-gray-400 rounded-md p-2 border bg-white"
                    multiple>
                    @foreach ($victims as $victim)
                        <option value="{{ $victim->id }}" 
                            {{ in_array($victim->id, $report->victims->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $victim->name }} - {{ $victim->lastName }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="w-1/3">
                <label for="accuseds" class="block text-gray-700 font-bold uppercase">Acusados</label>
                <select name="accuseds[]" id="accuseds" class="w-full border-gray-400 rounded-md p-2 border bg-white"
                    multiple>
                    @foreach ($accuseds as $accused)
                        <option value="{{ $accused->id }}" 
                            {{ in_array($accused->id, $report->accuseds->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $accused->name }} {{ $accused->lastName }} - ({{ $accused->nickName }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="w-1/3">
                <label for="vehicles" class="block text-gray-700 font-bold uppercase">Vehículos</label>
                <select name="vehicles[]" id="vehicles" class="w-full border-gray-400 rounded-md p-2 border bg-white"
                    multiple>
                    @foreach ($vehicles as $vehicle)
                        <option value="{{ $vehicle->id }}" 
                            {{ in_array($vehicle->id, $report->vehicles->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $vehicle->brand }} {{ $vehicle->model }} - ({{ $vehicle->plate_number }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mx-auto my-2 p-5 w-full">
            <label for="map" class="block text-gray-700 font-bold uppercase">Ubicación</label>
            <div id="map" style="height: 400px; width: 100%;" class="z-0"></div>
        </div>

        <div class="flex flex-col gap-5 border-gray-300 w-full border mx-auto p-5 my-3 rounded-md bg-slate-100">
            <div>
                <label for="latitude" class="block text-gray-700 font-bold uppercase">Latitud</label>
                <input type="text" id="latitude" name="latitude"
                    class="w-full border-gray-400 rounded-md p-2 border bg-white" 
                    value="{{ old('latitude', $report->location->latitude) }}" readonly required>
            </div>
            <div>
                <label for="longitude" class="block text-gray-700 font-bold uppercase">Longitud</label>
                <input type="text" id="longitude" name="longitude"
                    class="w-full border-gray-400 rounded-md p-2 border bg-white" 
                    value="{{ old('longitude', $report->location->longitude) }}" readonly required>
            </div>
            <div>
                <label for="address" class="block text-gray-700 font-bold uppercase">Dirección</label>
                <input type="text" id="address" name="address"
                    class="w-full border-gray-400 rounded-md p-2 border bg-white" 
                    value="{{ old('address', $report->location->address) }}" readonly required>
            </div>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md cursor-pointer">Actualizar</button>
    </form>
</div>

@push('scripts')
<script>
// Función para eliminar cámaras
function removeCamera(cameraId) {
    document.getElementById(`camera-${cameraId}`).remove();
    document.getElementById(`hidden-camera-${cameraId}`).remove();
}

// Espera a que Leaflet esté disponible
function waitForLeaflet(callback) {
    if (window.L) {
        callback();
    } else {
        setTimeout(() => waitForLeaflet(callback), 100);
    }
}

document.addEventListener("DOMContentLoaded", function() {
    waitForLeaflet(function() {
        // Coordenadas actuales del informe
        const initialLat = {{ $report->location->latitude }};
        const initialLng = {{ $report->location->longitude }};
        
        // Inicializar el mapa
        var map = L.map('map').setView([initialLat, initialLng],
     14); // El 14 es un nivel de zoom adecuado para ver la ciudad

     // Cargar el mapa con OpenStreetMap
     L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
         attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
     }).addTo(map);

        // Agregar marcador en la ubicación actual
        const marker = L.marker([initialLat, initialLng], {
            draggable: true
        }).addTo(map)
        .bindPopup('Arrastra el marcador a la nueva ubicación')
        .openPopup();

        // Actualizar campos cuando se mueve el marcador
        marker.on('dragend', function(e) {
            const latlng = e.target.getLatLng();
            updatePositionFields([latlng.lat, latlng.lng]);
        });

        // Función para actualizar los campos de posición
        function updatePositionFields([lat, lng]) {
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
            
            // Obtener dirección
            fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('address').value = data.display_name || 'Dirección no disponible';
                })
                .catch(error => {
                    console.error('Error al obtener dirección:', error);
                    document.getElementById('address').value = 'Error al obtener dirección';
                });
        }
    });

    // Código para manejar las cámaras
    const cameraSearch = document.getElementById("cameraSearch");
    const cameraSelect = document.getElementById("cameras");
    const addCameraButton = document.getElementById("addCamera");
    const selectedCamerasList = document.getElementById("selectedCameras");
    const hiddenInputsContainer = document.getElementById("hiddenInputsContainer");

    cameraSearch.addEventListener("input", function() {
        const searchValue = this.value.toLowerCase();
        Array.from(cameraSelect.options).forEach(option => {
            option.style.display = option.text.toLowerCase().includes(searchValue) ? "block" : "none";
        });
    });

    addCameraButton.addEventListener("click", function() {
        Array.from(cameraSelect.selectedOptions).forEach(option => {
            if (!document.getElementById(`camera-${option.value}`)) {
                const li = document.createElement("li");
                li.textContent = option.text;
                li.id = `camera-${option.value}`;

                const removeButton = document.createElement("button");
                removeButton.textContent = " ❌";
                removeButton.classList.add("ml-2", "text-red-500");
                removeButton.addEventListener("click", function() {
                    removeCamera(option.value);
                });

                li.appendChild(removeButton);
                selectedCamerasList.appendChild(li);

                const hiddenInput = document.createElement("input");
                hiddenInput.type = "hidden";
                hiddenInput.name = "cameras[]";
                hiddenInput.value = option.value;
                hiddenInput.id = `hidden-camera-${option.value}`;
                hiddenInputsContainer.appendChild(hiddenInput);
            }
        });
    });
});
</script>
@endpush
@endsection