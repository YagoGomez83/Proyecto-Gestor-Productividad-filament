@extends('layouts.app')

@section('title', 'Agregar cámara')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-4">Agregar una nueva cámara</h2>

    <form action="{{ route('cameras.store') }}" method="POST">
        @csrf

        <!-- Identificador -->
        <div class="mb-4">
            <label for="identifier" class="block text-gray-700">ID</label>
            <input type="text" name="identifier" id="identifier" class="w-full border-gray-300 rounded-md" placeholder="Ej. SL 01 - Illia y San Martín" value="{{ old('identifier') }}" required>
            @error('identifier')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <!-- Ciudades -->
        <div class="mb-4">
            <label for="city_id" class="block text-gray-700">Ciudades</label>
            <select name="city_id" id="city_id" class="w-full border-gray-300 rounded-md" required>
                <option value="" disabled selected>Seleccione una ciudad</option>
                @foreach ($cities as $city)
                    <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                @endforeach
            </select>
            @error('city_id')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <!-- Seleccionar Dependencia -->
        <div class="mb-4">
            <label for="police_station_id" class="block text-gray-700">Comisarías</label>
            <select name="police_station_id" id="police_station_id" class="w-full border-gray-300 rounded-md" required>
                <option value="" disabled selected>Seleccione una dependencia</option>
                @foreach ($policeStations as $policeStation)
                    <option value="{{ $policeStation->id }}" {{ old('police_station_id') == $policeStation->id ? 'selected' : '' }}>{{ $policeStation->name }}</option>
                @endforeach
            </select>
            @error('police_station_id')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <!-- Mapa para seleccionar ubicación -->
        <div class="mb-4">
            <label for="map" class="block text-gray-700">Ubicación</label>
            <div id="map" style="height: 400px;"></div>
        </div>

        <!-- Latitud -->
        <div class="mb-4">
            <label for="latitude" class="block text-gray-700">Latitud</label>
            <input type="text" id="latitude" name="latitude" class="w-full border-gray-300 rounded-md" value="{{ old('latitude') }}" readonly required>
            @error('latitude')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <!-- Longitud -->
        <div class="mb-4">
            <label for="longitude" class="block text-gray-700">Longitud</label>
            <input type="text" id="longitude" name="longitude" class="w-full border-gray-300 rounded-md" value="{{ old('longitude') }}" readonly required>
            @error('longitude')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <!-- Dirección -->
        <div class="mb-4">
            <label for="address" class="block text-gray-700">Dirección</label>
            <input type="text" id="address" name="address" class="w-full border-gray-300 rounded-md" value="{{ old('address') }}" readonly required>
            @error('address')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <!-- Botón para guardar -->
        <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded-md cursor-pointer">Guardar Cámara</button>
    </form>
</div>

<!-- Scripts de Leaflet -->
<script>
    // Coordenadas iniciales (San Luis, Argentina)
    var initialLat = -33.2951;
    var initialLng = -66.3379;

    // Inicializar mapa
    var map = L.map('map').setView([initialLat, initialLng], 14);

    // Agregar capa base de OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Agregar marcador de ubicación
    var marker = L.marker([initialLat, initialLng], { draggable: true }).addTo(map);

    // Actualizar campos de latitud, longitud y dirección
    function updateLocation(lat, lng) {
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;

        // Obtener dirección usando un servicio de geocodificación (ejemplo con Nominatim)
        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('address').value = data.display_name || 'Dirección no encontrada';
            });
    }

    // Evento al arrastrar marcador
    marker.on('dragend', function (e) {
        var lat = e.target.getLatLng().lat;
        var lng = e.target.getLatLng().lng;
        updateLocation(lat, lng);
    });

    // Inicializar campos
    updateLocation(initialLat, initialLng);
</script>
@endsection
