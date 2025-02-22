@extends('layouts.app')

@section('title', 'Cámaras Eliminadas')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Cámaras Eliminadas</h2>
    <div class="mx-auto mb-6 flex justify-start gap-2">

    <a href="{{ route('cameras.custom') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md mb-6">
        Volver al Listado
    </a>
    </div>

    <table class="table-auto w-full border-collapse border border-gray-200">
        <thead>
            <tr>
                <th class="border border-gray-300 px-4 py-2 text-left">ID</th>
                <th class="border border-gray-300 px-4 py-2 text-left">Ciudad</th>
                <th class="border border-gray-300 px-4 py-2 text-left">Dependencia</th>
                <th class="border border-gray-300 px-4 py-2 text-left">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cameras as $camera)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ $camera->identifier }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $camera->city->name ?? 'N/A' }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $camera->policeStation->name ?? 'N/A' }}</td>
                    <td class="border border-gray-300 px-4 py-2">
                        <form action="{{ route('camera.restore', $camera->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white py-1 px-3 rounded-md cursor-pointer">
                                Restaurar
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
