<div class="bg-gray-50 p-4 rounded-lg mb-6">
    <h2 class="text-lg font-semibold mb-4">Filtros</h2>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Filtro por Causa -->
        <div>
            <label for="causeFilter" class="block text-sm font-medium text-gray-700">Causa</label>
            <select id="causeFilter" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <option value="">Todas las causas</option>
                @foreach($causes as $cause)
                    <option value="{{ $cause->id }}">{{ $cause->cause_name }}</option>
                @endforeach
            </select>
        </div>
        
        <!-- Filtro por Comisaría -->
        <div>
            <label for="policeStationFilter" class="block text-sm font-medium text-gray-700">Comisaría</label>
            <select id="policeStationFilter" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <option value="">Todas las comisarías</option>
                @foreach($policeStations as $station)
                    <option value="{{ $station->id }}">{{ $station->name }}</option>
                @endforeach
            </select>
        </div>
        
        <!-- Filtro por Fecha -->
        <div>
            <label for="dateFilter" class="block text-sm font-medium text-gray-700">Fecha</label>
            <input type="date" id="dateFilter" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
        
        <!-- Filtro por Hora -->
        <div>
            <label for="timeFilter" class="block text-sm font-medium text-gray-700">Hora</label>
            <input type="time" id="timeFilter" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
    </div>
    
    <div class="mt-4 flex justify-end">
        <button id="applyFilters" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
            Aplicar Filtros
        </button>
        <button id="resetFilters" class="ml-2 px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
            Reiniciar
        </button>
    </div>
</div>