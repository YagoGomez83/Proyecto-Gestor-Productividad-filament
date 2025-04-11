@extends('layouts.app')
@section('title', 'Mapa de Calor de Infomes')
    
@endsection
@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Mapa de Calor de Reportes</h2>

    <form action="{{ route('heatmap.index') }}" method="GET" class="bg-white shadow-md rounded px-6 py-4 mb-6">
        @csrf
        <!-- Filtros para Cause, Dependency y Fechas -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label for="cause_id" class="block text-gray-700 font-medium mb-2">Causa</label>
                <select name="cause_id" id="cause_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Seleccione una causa</option>
                    @foreach($causes as $cause)
                        <option value="{{ $cause->id }}" {{ request('cause_id') == $cause->id ? 'selected' : '' }}>
                            {{ $cause->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="dependence_id" class="block text-gray-700 font-medium mb-2">Dependencia</label>
                <select name="dependence_id" id="dependence_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Seleccione una dependencia</option>
                    @foreach($dependencies as $dependence)
                        <option value="{{ $dependence->id }}" {{ request('dependence_id') == $dependence->id ? 'selected' : '' }}>
                            {{ $dependence->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="start_date" class="block text-gray-700 font-medium mb-2">Fecha de Inicio</label>
                <input type="date" name="start_date" id="start_date" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ request('start_date') }}" />
            </div>

            <div>
                <label for="end_date" class="block text-gray-700 font-medium mb-2">Fecha de Fin</label>
                <input type="date" name="end_date" id="end_date" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ request('end_date') }}" />
            </div>
        </div>

        <div class="mt-4 text-right">
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white font-medium rounded-md shadow-sm hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Filtrar
            </button>
        </div>
    </form>

    <div id="map" class="w-full rounded-lg shadow-lg" style="height: 500px;"></div>
</div>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.heat/0.2.0/leaflet-heat.js"></script>


<script>
    // Coordenadas predeterminadas (San Luis, Argentina)
    const defaultLat = -33.301726;
    const defaultLng = -66.337752;

    // Datos del mapa de calor
    const rawHeatData = @json($heatData);
    const heatData = rawHeatData.map(point => {
        if (point.length >= 4) {
            return [
                parseFloat(point[0]),
                parseFloat(point[1]),
                parseFloat(point[2]) * 5,
                parseFloat(point[3])
            ];
        }
        return null;
    }).filter(Boolean); // Eliminar datos nulos

    // Inicializar el mapa
    const centerLat = heatData.length > 0 ? heatData[0][0] : defaultLat;
    const centerLng = heatData.length > 0 ? heatData[0][1] : defaultLng;
    const map = L.map('map').setView([centerLat, centerLng], 12);

    // Capa base del mapa
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Agregar marcadores con enlaces
    heatData.forEach(data => {
        const marker = L.circleMarker([data[0], data[1]], {
            radius:30,
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.5
        }).addTo(map);

        marker.bindPopup(
            `<a href="/reports/${data[3]}" class="text-blue-600 hover:underline">Ver Informe</a>`
        );
    });

    // Agregar capa de calor si hay datos
    if (heatData.length > 0) {
        L.heatLayer(heatData, {
            radius: 25,
            blur: 15,
            maxZoom: 18,
            minOpacity: 0.5
        }).addTo(map);
    } else {
        console.warn("No se encontraron datos para el mapa de calor.");
    }
</script>







@endsection
