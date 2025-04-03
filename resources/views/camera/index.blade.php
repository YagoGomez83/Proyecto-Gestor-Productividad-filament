@extends('layouts.app')

@section('title', 'Listado de Cámaras')

@section('content')
   <div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Listado de Cámaras</h2>

    <!-- Formulario de Búsqueda -->
    <form method="GET" action="{{ route('cameras.custom') }}" class="mb-4">
        <div class="flex space-x-2">
            <input type="text" name="search" placeholder="Buscar por ID o Ciudad"
                   value="{{ request('search') }}"
                   class="border border-gray-300 px-4 py-2 rounded-md w-1/3">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md cursor-pointer">
                Buscar
            </button>
        </div>
    </form>

    <div class="mx-auto mb-6 flex justify-end gap-2">
        <a href="{{ route('camera.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md mb-6">
            Agregar Cámara
        </a>
        <a href="{{ route('cameras.deleted') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md mb-6">Camaras eliminadas</a>
        <a href="{{ route('cameras.heatmap') }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-md mb-6">Mapa de Calor</a>
    </div>

    <table class="table-auto w-full border-collapse border border-gray-200">
        <thead>
            <tr>
                <th class="border border-gray-300 px-4 py-2 text-left">ID</th>
                <th class="border border-gray-300 px-4 py-2 text-left">Ciudad</th>
                <th class="border border-gray-300 px-4 py-2 text-left">Dependencia</th>
                <th class="border border-gray-300 px-4 py-2 text-left">Dirección</th>
                <th class="border border-gray-300 px-4 py-2 text-left">Latitud</th>
                <th class="border border-gray-300 px-4 py-2 text-left">Longitud</th>
                <th class="border border-gray-300 px-4 py-2 text-left">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cameras as $camera)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ $camera->identifier }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $camera->city->name }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $camera->policeStation->name }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $camera->location->address }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $camera->location->latitude }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $camera->location->longitude }}</td>
                    <td class="border border-gray-300 px-4 py-2">
                        <div class="flex space-x-2">
                            <a href="{{ route('camera.show', $camera->id) }}" class="text-blue-500 hover:text-blue-600">Ver</a>
                            <a href="{{ route('camera.editar', $camera->id) }}" class="text-yellow-500 hover:text-yellow-600">Editar</a>
                            <form action="{{ route('camera.delete', $camera->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta cámara?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-600">Eliminar</button>
                            </form>
                            
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">
        {{ $cameras->links() }} {{-- Mostrará los enlaces de paginación --}}
    </div>
   </div>
@endsection
