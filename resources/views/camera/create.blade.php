@extends('layouts.app')

@section('title', 'Agregar Cámara')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md flex flex-col gap-5">
    <h2 class="text-2xl font-bold mb-4">Agregar una Nueva Cámara</h2>

    @if ($errors->any())
        <div class="bg-red-500 text-white p-3 rounded-md">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('cameras.store') }}" method="POST">
        @csrf

        <div class="flex flex-row gap-5 border-gray-300 w-full border mx-auto p-5 my-3 rounded-md bg-slate-100">
            <!-- Identificador -->
            <div class="w-full">
                <label for="identifier" class="block text-gray-700 font-bold uppercase">*ID</label>
                <input type="text" name="identifier" id="identifier" 
                    class="w-full border border-gray-400 rounded-md p-2 bg-white" 
                    placeholder="Ej. SL 01 - Illia y San Martín" 
                    value="{{ old('identifier') }}" required>
                @error('identifier')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="flex flex-row gap-5 border-gray-300 w-full border mx-auto p-5 my-3 rounded-md bg-slate-100">
            <!-- Ciudades -->
            <div class="w-1/2">
                <label for="city_id" class="block text-gray-700 font-bold uppercase">*Ciudad</label>
                <select name="city_id" id="city_id" 
                    class="w-full border border-gray-400 rounded-md p-2 bg-white" required>
                    <option value="" disabled selected>Seleccione una ciudad</option>
                    @foreach ($cities as $city)
                        <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>
                            {{ $city->name }}
                        </option>
                    @endforeach
                </select>
                @error('city_id')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <!-- Dependencia -->
            <div class="w-1/2">
                <label for="police_station_id" class="block text-gray-700 font-bold uppercase">*Dependencia</label>
                <select name="police_station_id" id="police_station_id" 
                    class="w-full border border-gray-400 rounded-md p-2 bg-white" required>
                    <option value="" disabled selected>Seleccione una dependencia</option>
                    @foreach ($policeStations as $policeStation)
                        <option value="{{ $policeStation->id }}" {{ old('police_station_id') == $policeStation->id ? 'selected' : '' }}>
                            {{ $policeStation->name }}
                        </option>
                    @endforeach
                </select>
                @error('police_station_id')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Mapa para seleccionar ubicación -->
        <div class="mx-auto my-2 p-5 w-full">
            <label for="map" class="block text-gray-700 font-bold uppercase">Ubicación</label>
            <div id="map" style="height: 400px; width: 100%;" class="z-0"></div>
        </div>

        <!-- Campos de coordenadas -->
        <div class="flex flex-col gap-5 border-gray-300 w-full border mx-auto p-5 my-3 rounded-md bg-slate-100">
            <div>
                <label for="latitude" class="block text-gray-700 font-bold uppercase">*Latitud</label>
                <input type="text" id="latitude" name="latitude"
                    class="w-full border border-gray-400 rounded-md p-2 bg-white" 
                    value="{{ old('latitude') }}" readonly required>
                @error('latitude')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="longitude" class="block text-gray-700 font-bold uppercase">*Longitud</label>
                <input type="text" id="longitude" name="longitude"
                    class="w-full border border-gray-400 rounded-md p-2 bg-white" 
                    value="{{ old('longitude') }}" readonly required>
                @error('longitude')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="address" class="block text-gray-700 font-bold uppercase">*Dirección</label>
                <input type="text" id="address" name="address"
                    class="w-full border border-gray-400 rounded-md p-2 bg-white" 
                    value="{{ old('address') }}" readonly required>
                @error('address')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md cursor-pointer">Guardar Cámara</button>
    </form>
</div>

@push('scripts')
<script>
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
        // Inicializar el mapa
        const map = initMap('map');
        
        if (!map) {
            console.error('No se pudo inicializar el mapa');
            return;
        }

        // Coordenadas de Plaza Pringles
        const plazaPringlesLatLng = [-33.2920, -66.3340];

        // Agregar marcador
        const marker = L.marker(plazaPringlesLatLng, {
            draggable: true
        }).addTo(map)
        .bindPopup('Arrastra el marcador a la ubicación correcta')
        .openPopup();

        // Inicializar campos con posición del marcador
        updatePositionFields(plazaPringlesLatLng);

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
});
</script>
@endpush
@endsection