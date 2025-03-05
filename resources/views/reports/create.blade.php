@extends('layouts.app')

@section('title', 'Crear Informe')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-4">Crear un Nuevo Informe</h2>
<p class="bg-lime-700 text-white font-bold rounded-md p-4 my-3 text-center">Consultar si las cámaras, comisarias, vehículos, sospechosos y victimas estan creadas, si no por favor agregarlas</p>
    <form action="{{ route('reports.store') }}" method="POST">
        @csrf

               <!-- Título -->
               <div class="mb-4">
                <label for="title" class="block text-gray-700">*Título</label>
                <input type="text" name="title" id="title" class="w-full border-gray-300 rounded-md" value="{{ old('title') }}" required>
            </div>
            @error('title')
                <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror
    
    
            <!-- Descripción -->
            <div class="mb-4">
                <label for="description" class="block text-gray-700">*Descripción</label>
                <textarea name="description" id="description" class="w-full border-gray-300 rounded-md" required>{{ old('description') }}</textarea>
            </div>
    
            @error('description')
                <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror
    
            <!-- Fecha del informe -->
            <div class="mb-4">
                <label for="report_date" class="block text-gray-700">*Fecha</label>
                <input type="date" name="report_date" id="report_date" class="w-full border-gray-300 rounded-md" value="{{ old('report_date') }}" required>
            </div>
    
            @error('report_date')
                <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror
    
            <!-- Hora del informe -->
            <div class="mb-4">
                <label for="report_time" class="block text-gray-700">*Hora</label>
                <input type="time" name="report_time" id="report_time" class="w-full border-gray-300 rounded-md" value="{{ old('report_time') }}" required>
            </div>
    
            @error('report_time')
                <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror
    
            {{-- camaras --}}
    
            <div class="mb-4">
                <label for="cameras" class="block text-gray-700">Camaras</label>
                <select name="cameras[]" id="cameras" class="w-full border-gray-300 rounded-md" required multiple>
                    @foreach ($cameras as $camera)
                    <option value="{{ $camera->id }}">{{ $camera->identifier }}</option>
                    @endforeach
                </select>
                <div class="mt-2">
                    <a href="{{ route('camera.create') }}" class="text-blue-500">Agregar una cámara</a>
                </div>
            </div>
            @error('cameras')
                <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror
    
            <!-- Dependencia -->
            <div class="mb-4">
                <label for="police_station_id" class="block text-gray-700">Comisaria</label>
        <select name="police_station_id" id="police_station_id" class="w-full border-gray-300 rounded-md" required>
            @foreach ($policeStations as $policeStation)
            <option value="{{ $policeStation->id }}">{{ $policeStation->name }}</option>
            @endforeach
        </select>
                <div class="mt-2">
                    <a href="{{ route('filament.admin.resources.police-stations.create') }}" class="text-blue-500">Agregar una nueva Comisaría</a>
                </div>
            </div>
            @error('police_station_id')
                <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror

        <!-- Mapa con campos de latitud, longitud y dirección -->
        <div class="mb-4">
            <label for="map" class="block text-gray-700">Ubicación</label>
            <div id="map" style="height: 400px;"></div>
        </div>

        <div class="mb-4">
            <label for="latitude" class="block text-sm font-medium text-gray-700">Latitud</label>
            <input type="text" id="latitude" name="latitude" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" readonly required>
        </div>

        <div class="mb-4">
            <label for="longitude" class="block text-sm font-medium text-gray-700">Longitud</label>
            <input type="text" id="longitude" name="longitude" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" readonly required>
        </div>

        <div class="mb-4">
            <label for="address" class="block text-sm font-medium text-gray-700">Dirección</label>
            <input type="text" id="address" name="address" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" readonly required>
        </div>

        <!-- Causa -->
        <div class="mb-4">
            <label for="cause_id" class="block text-gray-700">Causa</label>
            <select name="cause_id" id="cause_id" class="w-full border-gray-300 rounded-md" required>
                @foreach($causes as $cause)
                    <option value="{{ $cause->id }}">{{ $cause->cause_name }}</option>
                @endforeach
            </select>
            <div class="mt-2">
                <a href="{{ route('filament.admin.resources.causes.create') }}" class="text-blue-500">Agregar una causa nueva</a>
            </div>
        </div>
        @error('cause_id')
            <div class="text-red-500 text-sm">{{ $message }}</div>
        @enderror

        <!-- Vehículos -->
        <div class="mb-4">
            <label for="vehicles" class="block text-gray-700">Vehículos (Opcional)</label>
            <select name="vehicles[]" id="vehicles" class="w-full border-gray-300 rounded-md" multiple>
                @foreach($vehicles as $vehicle)
                    <option value="{{ $vehicle->id }}">{{ $vehicle->brand }} - {{ $vehicle->model }} {{ $vehicle->color }}-({{ $vehicle->plate_number }})</option>
                @endforeach
            </select>
            <div class="mt-2">
                <a href="{{ route('filament.admin.resources.vehicles.create') }}" class="text-blue-500">Agregar un nuevo vehículo</a>
            </div>
        </div>
        @error('vehicles')
            <div class="text-red-500 text-sm">{{ $message }}</div>
        @enderror

        <!-- Víctimas -->
        <div class="mb-4">
            <label for="victims" class="block text-gray-700">Víctimas (Opcional)</label>
            <select name="victims[]" id="victims" class="w-full border-gray-300 rounded-md" multiple>
                @foreach($victims as $victim)
                    <option value="{{ $victim->id }}">{{ $victim->name }} - {{ $victim->lastName }}</option>
                @endforeach
            </select>
            <div class="mt-2">
                <a href="{{ route('filament.admin.resources.victims.create') }}" class="text-blue-500">Agregar una nueva víctima</a>
            </div>
        </div>
        @error('victims')
            <div class="text-red-500 text-sm">{{ $message }}</div>
        @enderror

        <!-- Acusados -->
        <div class="mb-4">
            <label for="accuseds" class="block text-gray-700">Acusados(Opcional)</label>
            <select name="accuseds[]" id="accuseds" class="w-full border-gray-300 rounded-md" multiple>
                @foreach($accuseds as $accused)
                    <option value="{{ $accused->id }}">{{ $accused->name }} {{ $accused->lastName }} - ({{ $accused->nickName }})</option>
                @endforeach
            </select>
            <div class="mt-2">
                <a href="{{ route('filament.admin.resources.accuseds.create') }}" class="text-blue-500">Agregar un nuevo acusado</a>
            </div>
        </div>
        @error('accuseds')
            <div class="text-red-500 text-sm">{{ $message }}</div>
        @enderror

        <!-- Botón de Enviar -->
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md cursor-pointer">Guardar</button>
    </form>
</div>

<!-- Agregar Script de Leaflet -->
<script>
    // Coordenadas de San Luis, Argentina
    var sanLuisLat = -33.2951;
    var sanLuisLng = -66.3379;

    // Coordenadas de Plaza Pringles
    var plazaPringlesLat = -33.2920;
    var plazaPringlesLng = -66.3340;

    // Inicializar el mapa centrado en San Luis con un nivel de zoom que se ajusta a la ciudad
    var map = L.map('map').setView([sanLuisLat, sanLuisLng], 14); // El 14 es un nivel de zoom adecuado para ver la ciudad

    // Cargar el mapa con OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Agregar un marcador en Plaza Pringles
    var marker = L.marker([plazaPringlesLat, plazaPringlesLng]).addTo(map)
        .bindPopup('Plaza Pringles, San Luis') // Opcional: mensaje emergente al hacer clic
        .openPopup();

    // Actualizar los campos de latitud, longitud y dirección cuando se mueva el marcador
    marker.on('dragend', function(e) {
        var latlng = e.target.getLatLng();
        document.getElementById('latitude').value = latlng.lat;
        document.getElementById('longitude').value = latlng.lng;

        // Usar una API de geocodificación para obtener la dirección
        fetch(`https://nominatim.openstreetmap.org/reverse?lat=${latlng.lat}&lon=${latlng.lng}&format=json`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('address').value = data.display_name;
            });
    });

    // Hacer el marcador arrastrable
    marker.dragging.enable();
</script>
@endsection
