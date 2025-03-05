@extends('layouts.app')

@section('title', 'Detalle del Informe')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-4">{{ $report->title }}</h2>
    <p><strong>Fecha:</strong> {{ $report->report_date }}</p>
    <p><strong>Hora:</strong> {{ $report->report_time }}</p>
    <p><strong>Descripción:</strong> {{ $report->description }}</p>
    <p><strong>Ubicación:</strong> {{ $report->location->address }}</p>
    <p><strong>Causa:</strong> {{ $report->cause->cause_name }}</p>
    <p><strong>Dependencia:</strong> {{ $report->policeStation->name }}</p>

    <hr class="my-4">
    <hr class="my-4">

    {{-- Mapa --}}
    <h3 class="text-xl font-bold mb-4">Mapa de la Ubicación:</h3>
    <div id="map" style="height: 400px;" class="mb-4"></div>

    <hr class="my-4">

    {{-- Vehículos involucrados --}}
    <h3 class="text-xl font-bold">Vehículos Involucrados:</h3>
    @if($report->vehicles->isNotEmpty())
        <ul class="list-disc ml-6">
            @foreach($report->vehicles as $vehicle)
                <li>{{ $vehicle->brand }} {{ $vehicle->model }} ({{ $vehicle->plate_number }})</li>
            @endforeach
        </ul>
    @else
        <p>No hay vehículos involucrados en este informe.</p>
    @endif

    <hr class="my-4">

    {{-- Cámaras asociadas --}}
    <h3 class="text-xl font-bold">Cámaras Asociadas:</h3>
    @if($report->cameras->isNotEmpty())
        <ul class="list-disc ml-6">
            @foreach($report->cameras as $camera)
                <li>Cámara ID: {{ $camera->identifier }} </li>
            @endforeach
        </ul>
    @else
        <p>No hay cámaras asociadas a este informe.</p>
    @endif

    <hr class="my-4">

    {{-- Víctimas --}}
    <h3 class="text-xl font-bold">Víctimas:</h3>
    @if($report->victims->isNotEmpty())
        <ul class="list-disc ml-6">
            @foreach($report->victims as $victim)
                <li>{{ $victim->name }} - {{ $victim->lastName }} años</li>
            @endforeach
        </ul>
    @else
        <p>No hay víctimas asociadas a este informe.</p>
    @endif

    <hr class="my-4">

    {{-- Acusados --}}
    <h3 class="text-xl font-bold">Acusados:</h3>
    @if($report->accuseds->isNotEmpty())
        <ul class="list-disc ml-6">
            @foreach($report->accuseds as $accused)
                <li>{{ $accused->name }}  {{ $accused->lastName }} - ({{ $accused->nickName }})</li>
            @endforeach
        </ul>
    @else
        <p>No hay acusados asociados a este informe.</p>
    @endif
    <div class="my-5 mx-auto w-full p-3">
        <a href="{{ route('reports.custom') }}" class="text-blue-600 text-center text-sm hover:text-blue-700 uppercase block hover:underline">Volver</a>
        </div>
</div>
<!-- Agregar Script de Leaflet -->
<script>
    // Coordenadas de la ubicación
    var latitude = {{ $report->location->latitude }};
    var longitude = {{ $report->location->longitude }};

    // Inicializar el mapa
    var map = L.map('map').setView([latitude, longitude], 15);

    // Agregar capa de mapa (OpenStreetMap)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map);

    // Agregar marcador
    L.marker([latitude, longitude])
        .addTo(map)
        .bindPopup("{{ $report->location->address }}")
        .openPopup();
</script>

@endsection
