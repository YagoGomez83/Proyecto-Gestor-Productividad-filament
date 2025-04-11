@extends('layouts.app')

@section('content')
<div class="w-full px-4 py-6">
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Filtros -->
        <div class="w-full lg:w-1/4 bg-white shadow rounded-xl p-4">
            <h2 class="text-lg font-semibold mb-4 border-b pb-2">Filtros</h2>
            <form id="heatmap-filters" method="GET" action="{{ route('heatmap.services') }}" class="space-y-4">
                <div>
                    <label for="city_id" class="block text-sm font-medium text-gray-700">Ciudad</label>
                    <select name="city_id" id="city_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                        <option value="">Todas</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}" {{ data_get($filters, 'city_id') == $city->id ? 'selected' : '' }}>
                                {{ $city->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="initial_code_id" class="block text-sm font-medium text-gray-700">Código Inicial</label>
                    <select name="initial_code_id" id="initial_code_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                        <option value="">Todos</option>
                        @foreach ($initialCodes as $code)
                            <option value="{{ $code->id }}" {{ data_get($filters, 'initial_code_id') == $code->id ? 'selected' : '' }}>
                                {{ $code->description ?? $code->code }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Tipo de Servicio</label>
                    <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                        <option value="">Todos</option>
                        <option value="preventive" {{ data_get($filters, 'status') == 'preventive' ? 'selected' : '' }}>Preventivo</option>
                        <option value="reactive" {{ data_get($filters, 'status') == 'reactive' ? 'selected' : '' }}>Reactivo</option>
                    </select>
                </div>

                <div>
                    <label for="group_id" class="block text-sm font-medium text-gray-700">Grupo</label>
                    <select name="group_id" id="group_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                        <option value="">Todos</option>
                        {{-- Suponiendo que ya tenés los grupos cargados --}}
                        @foreach ($groups ?? [] as $group)
                            <option value="{{ $group->id }}" {{ data_get($filters, 'group_id') == $group->id ? 'selected' : '' }}>
                                {{ $group->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700">Fecha Inicio</label>
                    <input type="date" name="start_date" id="start_date" value="{{ $filters['start_date'] ?? '' }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                </div>

                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700">Fecha Fin</label>
                    <input type="date" name="end_date" id="end_date" value="{{ $filters['end_date'] ?? '' }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                </div>

                <div>
                    <label for="start_time" class="block text-sm font-medium text-gray-700">Hora Inicio</label>
                    <input type="time" name="start_time" id="start_time" value="{{ $filters['start_time'] ?? '' }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                </div>

                <div>
                    <label for="end_time" class="block text-sm font-medium text-gray-700">Hora Fin</label>
                    <input type="time" name="end_time" id="end_time" value="{{ $filters['end_time'] ?? '' }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-2 px-4 rounded-lg transition">
                    Filtrar
                </button>
            </form>
        </div>

        <!-- Mapa -->
        <div class="w-full lg:w-3/4">
            <x-heatmap :heatData="$heatmapData" />

            {{-- @if (config('app.debug'))
                <div class="mt-6">
                    <h5 class="text-base font-semibold mb-2">Datos del Heatmap (Debug)</h5>
                    <pre class="bg-gray-100 p-3 rounded-md text-sm overflow-x-auto">{{ json_encode($heatmapData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                </div>
            @endif --}}
        </div>
    </div>
</div>
@endsection
