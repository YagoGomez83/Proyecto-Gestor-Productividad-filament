@extends('layouts.app')

@section('title', 'Editar Cámara')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-4">Editar Cámara</h2>

    <form action="{{ route('camera.update', $camera->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Identificador -->
        <div class="mb-4">
            <label for="identifier" class="block text-gray-700">ID</label>
            <input type="text" name="identifier" id="identifier" class="w-full border-gray-300 rounded-md" value="{{ old('identifier', $camera->identifier) }}" required>
            @error('identifier')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <!-- Ciudades -->
        <div class="mb-4">
            <label for="city_id" class="block text-gray-700">Ciudades</label>
            <select name="city_id" id="city_id" class="w-full border-gray-300 rounded-md" required>
                <option value="" disabled>Seleccione una ciudad</option>
                @foreach ($cities as $city)
                    <option value="{{ $city->id }}" {{ old('city_id', $camera->city_id) == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                @endforeach
            </select>
            @error('city_id')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <!-- Dependencia -->
        <div class="mb-4">
            <label for="police_station_id" class="block text-gray-700">Comisarías</label>
            <select name="police_station_id" id="police_station_id" class="w-full border-gray-300 rounded-md" required>
                <option value="" disabled>Seleccione una dependencia</option>
                @foreach ($policeStations as $policeStation)
                    <option value="{{ $policeStation->id }}" {{ old('police_station_id', $camera->police_station_id) == $policeStation->id ? 'selected' : '' }}>{{ $policeStation->name }}</option>
                @endforeach
            </select>
            @error('police_station_id')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <!-- Mapa para ubicación -->
        <div class="mb-4">
            <label for="map" class="block text-gray-700">Ubicación</label>
            <div id="map" style="height: 400px;"></div>
        </div>

        <!-- Latitud -->
        <div class="mb-4">
            <label for="latitude" class="block text-gray-700">Latitud</label>
            <input type="text" id="latitude" name="latitude" class="w-full border-gray-300 rounded-md" value="{{ old('latitude', $camera->location->latitude) }}" readonly required>
            @error('latitude')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <!-- Longitud -->
        <div class="mb-4">
            <label for="longitude" class="block text-gray-700">Longitud</label>
            <input type="text" id="longitude" name="longitude" class="w-full border-gray-300 rounded-md" value="{{ old('longitude', $camera->location->longitude) }}" readonly required>
            @error('longitude')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <!-- Dirección -->
        <div class="mb-4">
            <label for="address" class="block text-gray-700">Dirección</label>
            <input type="text" id="address" name="address" class="w-full border-gray-300 rounded-md" value="{{ old('address', $camera->location->address) }}" readonly required>
            @error('address')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <!-- Botón para actualizar -->
        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md cursor-pointer">Actualizar Cámara</button>
    </form>
</div>

<!-- Scripts de Leaflet -->
<script>
    var initialLat = {{ $camera->location->latitude }};
    var initialLng = {{ $camera->location->longitude }};

    var map = L.map('map').setView([initialLat, initialLng], 14);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    var marker = L.marker([initialLat, initialLng], { draggable: true }).addTo(map);

    function updateLocation(lat, lng) {
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;

        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('address').value = data.display_name || 'Dirección no encontrada';
            });
    }

    marker.on('dragend', function (e) {
        var lat = e.target.getLatLng().lat;
        var lng = e.target.getLatLng().lng;
        updateLocation(lat, lng);
    });

    updateLocation(initialLat, initialLng);
</script>
@endsection
