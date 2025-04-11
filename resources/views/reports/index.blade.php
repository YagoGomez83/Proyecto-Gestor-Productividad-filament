@extends('layouts.app')

@section('title', 'Mis Informes')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <form method="GET" action="{{ route('reports.custom') }}" class="mb-4">
        <div class="flex space-x-2">
            <input type="text" name="search" placeholder="Buscar Informe especial"
                   value="{{ request('search') }}"
                   class="border border-gray-300 px-4 py-2 rounded-md w-1/3">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md cursor-pointer">
                Buscar
            </button>
        </div>
    </form>
    <div class="mx-auto mb-6 flex justify-end gap-2">
        <a href="{{ route('report.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md mb-6">
            Crear Informe
        </a>
        <a href="{{ route('reports.deleted') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md mb-6">Informes eliminados</a>
        <a href="{{ route('heatmap.index') }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-md mb-6">Mapas de calor</a>
    </div>
    
    <h2 class="text-2xl font-bold mb-4">Mis Informes</h2>
    @if ($reports->isEmpty())
        <p>No hay informes aún.</p>
    @else
    <div class="overflow-x-auto">
        <table class="table-auto w-full border-collapse border border-gray-200 ">
            <thead>
                <tr>
                    
                    <th class="border border-gray-300 px-4 py-2 text-left">Título</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Descripción</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Fecha del Informe</th>                    
                    <th class="border border-gray-300 px-4 py-2 text-left">Dirección</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Comisaria</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Causa</th>                   
                    <th class="border border-gray-300 px-4 py-2 text-left">Creado por</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Acciones</th>
                </tr>
            </thead>
            </thead>
            <tbody>
                @foreach ($reports as $report)
                    <tr>
                        
                        <td class="border border-gray-300 px-4 py-2 text-left">{{$report->title }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-left">{{$report->description }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-left">{{ $report->report_date->format('d/m/Y') }}</td>                        
                        <td class="border border-gray-300 px-4 py-2 text-left">{{ optional($report->location)->address }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-left">{{ optional($report->policeStation)->name }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-left">{{ optional($report->cause)->cause_name }}</td>                        
                        <td class="border border-gray-300 px-4 py-2 text-left">{{ optional($report->user )->name}}</td>
                        <td class="border border-gray-300 px-4 py-2 text-left">
                            <div class="flex space-x-2">
                                <a href="{{ route('report.show', $report->id) }}" class="text-blue-500 hover:text-blue-600">Ver</a>
                                <a href="{{ route('report.editar', $report->id) }}" class="text-yellow-500 hover:text-yellow-600">Editar</a>
                                <form action="{{ route('report.delete', $report->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este informe?');">
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
    </div>
        <div class="mt-4">
            {{ $reports->links() }} {{-- Paginación --}}
        </div>
    @endif
</div>
@endsection
