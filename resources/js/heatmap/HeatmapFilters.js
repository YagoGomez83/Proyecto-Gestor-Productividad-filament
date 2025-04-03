export default class HeatmapFilters {
    static getReportFilters() {
        return {
            cause: document.getElementById('cause').value,
            date: document.getElementById('date').value,
            startTime: document.getElementById('startTime').value,
            endTime: document.getElementById('endTime').value
        };
    }

    static getServiceFilters() {
        return {
            service_type: document.getElementById('service_type').value,
            initial_police_movement_code_id: document.getElementById('initial_police_movement_code_id').value,
            police_station_id: document.getElementById('police_station_id').value,
            date: document.getElementById('service_date').value,
            startTime: document.getElementById('startTime').value,
            endTime: document.getElementById('endTime').value,
            type: 'services'
        };
    }

    static resetReportFilters() {
        document.getElementById('cause').value = '';
        document.getElementById('date').value = '';
        document.getElementById('startTime').value = '00:00';
        document.getElementById('endTime').value = '23:59';
        document.getElementById('timeRangeValue').textContent = '00:00 - 23:59';
    }

    static resetServiceFilters() {
        document.getElementById('service_type').value = '';
        document.getElementById('initial_police_movement_code_id').value = '';
        document.getElementById('police_station_id').value = '';
        document.getElementById('service_date').value = '';
        document.getElementById('startTime').value = '00:00';
        document.getElementById('endTime').value = '23:59';
        document.getElementById('timeRangeValue').textContent = '00:00 - 23:59';
    }

    static updateTimeRangeDisplay() {
        const startTime = document.getElementById('startTime').value;
        const endTime = document.getElementById('endTime').value;
        document.getElementById('timeRangeValue').textContent = `${startTime} - ${endTime}`;
    }
}