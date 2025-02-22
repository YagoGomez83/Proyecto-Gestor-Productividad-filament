@extends('layouts.app')

@section('title', 'Detalles de la Cámara')

@section('content')
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-bold mb-4">Detalles de la Cámara</h2>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <p><strong>ID:</strong> {{ $camera->identifier }}</p>
            <p><strong>Ciudad:</strong> {{ $camera->city->name }}</p>
            <p><strong>Dependencia:</strong> {{ $camera->policeStation->name }}</p>
            <p><strong>Dirección:</strong> {{ $camera->location->address }}</p>
            <p><strong>Latitud:</strong> {{ $camera->location->latitude }}</p>
            <p><strong>Longitud:</strong> {{ $camera->location->longitude }}</p>
            <a href="{{ route('cameras.custom') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-md mt-4 inline-block">Volver</a>
        </div>
    </div>
@endsection
