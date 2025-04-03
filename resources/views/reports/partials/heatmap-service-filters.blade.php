<div class="filter-card mb-4" id="serviceFilters">
    <h3 class="text-lg font-semibold mb-4 text-gray-800">Filtros de Servicios</h3>
    
    <form id="serviceFilterForm">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Tipo de Servicio -->
            <div class="filter-section">
                <label for="service_type" class="filter-label">Tipo de Servicio</label>
                <select id="service_type" name="service_type" class="form-select w-full">
                    <option value="">Todos</option>
                    <option value="preventive">Preventivo</option>
                    <option value="reactive">Reactivo</option>
                </select>
            </div>

            <!-- Código de Movimiento Policial -->
            <div class="filter-section">
                <label for="initial_police_movement_code_id" class="filter-label">Código de Movimiento</label>
                <select id="initial_police_movement_code_id" name="initial_police_movement_code_id" class="form-select w-full">
                    <option value="">Todos</option>
                    @foreach($policeMovementCodes as $code)
                        <option value="{{ $code->id }}">{{ $code->code }} - {{ $code->description }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Comisaría -->
            <div class="filter-section">
                <label for="police_station_id" class="filter-label">Comisaría</label>
                <select id="police_station_id" name="police_station_id" class="form-select w-full">
                    <option value="">Todas</option>
                    @foreach($policeStations as $station)
                        <option value="{{ $station->id }}">{{ $station->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
            <!-- Fecha -->
            <div class="filter-section">
                <label for="service_date" class="filter-label">Fecha</label>
                <input type="date" id="service_date" name="date" class="form-input w-full">
            </div>

            <!-- Rango de Horas -->
            <div class="filter-section">
                <label class="filter-label">Rango de Horas</label>
                <div class="flex items-center space-x-2">
                    <input type="time" id="startTime" name="start_time" value="00:00" class="form-input w-1/2">
                    <span>a</span>
                    <input type="time" id="endTime" name="end_time" value="23:59" class="form-input w-1/2">
                </div>
                <div class="text-sm text-gray-500 mt-1" id="timeRangeValue">00:00 - 23:59</div>
            </div>
        </div>

        <div class="flex justify-end mt-4 space-x-3">
            <button type="button" id="resetServiceFilters" class="btn btn-gray">
                Limpiar Filtros
            </button>
            <button type="submit" class="btn btn-primary">
                Aplicar Filtros
            </button>
        </div>
    </form>
</div>