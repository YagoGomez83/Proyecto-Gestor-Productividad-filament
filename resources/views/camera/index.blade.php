@extends('layouts.app')

@section('title', 'Gestión de Cámaras')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <header class="mb-8">
        <h1 class="text-3xl font-bold text-slate-800">Gestión de Cámaras</h1>
        <p class="mt-1 text-slate-600">Busca, visualiza y administra las cámaras del sistema.</p>
    </header>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        
        <div class="p-6 border-b border-slate-200">
            <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
                <form method="GET" action="{{ route('cameras.custom') }}" class="w-full sm:w-auto">
                    <div class="relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                        </svg>
                        <input type="text" name="search" placeholder="Buscar por ID o Ciudad..."
                               value="{{ request('search') }}"
                               class="border border-slate-300 pl-10 pr-4 py-2 rounded-lg w-full sm:w-80 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                    </div>
                    {{-- El botón de buscar es opcional, se puede enviar con Enter. Si lo quieres, puedes añadirlo aquí. --}}
                </form>

                <div class="flex items-center space-x-3">
                    <a href="{{ route('cameras.deleted') }}" class="bg-slate-100 text-slate-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-slate-200 transition-colors">
                        Ver Eliminadas
                    </a>
                    <a href="{{ route('heatmap.services') }}" class="bg-slate-100 text-slate-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-slate-200 transition-colors">
                        Mapa de Calor
                    </a>
                    <a href="{{ route('camera.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-indigo-700 transition-colors flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                        </svg>
                        <span>Agregar Cámara</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-600 uppercase tracking-wider font-semibold">
                    <tr>
                        <th scope="col" class="px-6 py-3">Identificador</th>
                        <th scope="col" class="px-6 py-3">Ciudad</th>
                        <th scope="col" class="px-6 py-3">Dependencia</th>
                        <th scope="col" class="px-6 py-3">Dirección</th>
                        <th scope="col" class="px-6 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse ($cameras as $camera)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-slate-900">{{ $camera->identifier }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $camera->city->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $camera->policeStation->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap max-w-xs truncate" title="{{ $camera->location->address }}">{{ $camera->location->address }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center space-x-4">
                                    <a href="{{ route('camera.show', $camera->id) }}" class="text-indigo-600 hover:text-indigo-800 transition-colors" title="Ver Detalles">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
                                            <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 010-1.18l.879-1.318A4.002 4.002 0 017.25 6h5.5a4.002 4.002 0 014.707 2.092l.879 1.318a1.651 1.651 0 010 1.18l-.879 1.318A4.002 4.002 0 0112.75 14h-5.5a4.002 4.002 0 01-4.707-2.092L.664 10.59zM17 10a7 7 0 11-14 0 7 7 0 0114 0z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('camera.editar', $camera->id) }}" class="text-green-600 hover:text-green-800 transition-colors" title="Editar Cámara">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M5.433 13.917l1.262-3.155A4 4 0 017.58 9.42l6.92-6.918a2.121 2.121 0 013 3l-6.92 6.918a4 4 0 01-1.343 1.059l-3.155 1.262a.5.5 0 01-.65-.65z" />
                                            <path d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0010 3H4.75A2.75 2.75 0 002 5.75v9.5A2.75 2.75 0 004.75 18h9.5A2.75 2.75 0 0017 15.25V10a.75.75 0 00-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('camera.delete', $camera->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta cámara?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 transition-colors" title="Eliminar Cámara">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.58.22-2.365.468a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193v-.443A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-10 text-slate-500">
                                <div class="flex flex-col items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="font-semibold">No se encontraron cámaras.</p>
                                    <p class="text-sm">Intenta con otros términos de búsqueda o agrega una nueva cámara.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-6 border-t border-slate-200">
            {{ $cameras->links() }}
        </div>
    </div>
</div>
@endsection