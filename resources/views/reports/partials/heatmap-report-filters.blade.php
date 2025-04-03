<div class="filter-card">
    <form id="filterForm">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Filtro por Causa -->
            <div class="filter-section">
                <label for="cause" class="filter-label">Filtrar por Causa</label>
                <select id="cause" name="cause" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Todas las causas</option>
                    @foreach($causes as $cause)
                        <option value="{{ $cause->id }}">{{ $cause->cause_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filtro por Fecha -->
            <div class="filter-section">
                <label for="date" class="filter-label">Filtrar por Fecha</label>
                <input type="date" id="date" name="date" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <!-- Filtro por Rango de Horas -->
            <div class="filter-section">
                <label for="timeRange" class="filter-label">Rango de Horas: <span id="timeRangeValue">00:00 - 23:59</span></label>
                <div class="flex items-center space-x-4 mt-2">
                    <input type="time" id="startTime" name="startTime" value="00:00" class="w-1/3 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <span class="text-gray-500">a</span>
                    <input type="time" id="endTime" name="endTime" value="23:59" class="w-1/3 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <button type="reset" id="resetFilters" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors">
                Limpiar Filtros
            </button>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                Aplicar Filtros
            </button>
        </div>
    </form>
</div>