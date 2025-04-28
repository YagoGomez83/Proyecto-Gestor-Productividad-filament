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
  // Coordenadas de San Luis, Argentina
  var sanLuisLat = -33.2951;
     var sanLuisLng = -66.3379;

     // Coordenadas de Plaza Pringles
     var plazaPringlesLat = -33.2920;
     var plazaPringlesLng = -66.3340;

     document.addEventListener('DOMContentLoaded', function() {
     // Inicializar el mapa centrado en San Luis con un nivel de zoom que se ajusta a la ciudad
     var map = L.map('map').setView([sanLuisLat, sanLuisLng],
     14); // El 14 es un nivel de zoom adecuado para ver la ciudad

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
    });
</script>
@endpush
@endsection