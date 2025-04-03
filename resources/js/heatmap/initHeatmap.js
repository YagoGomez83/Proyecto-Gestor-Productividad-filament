import HeatmapManager from './HeatmapManager.js';
import HeatmapService from './HeatmapService.js';
import HeatmapFilters from './HeatmapFilters.js';
import HeatmapUI from './HeatmapUI.js';
export default function initializeHeatmap(initialReportData, initialServiceData, route) {
    
    const heatmapManager = new HeatmapManager();
    const heatmapService = new HeatmapService(route);

    // Inicialización del mapa
    heatmapManager.initMap('mapReports', initialReportData);
    heatmapManager.updateHeatmap(initialReportData);

    // Configurar event listeners
    const setupEventListeners = () => {
        // Formulario de filtros de reportes
        const reportFilterForm = document.getElementById('filterForm');
        if (reportFilterForm) {
            reportFilterForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                await applyFilters(HeatmapFilters.getReportFilters());
            });
        }

        // Formulario de filtros de servicios
        const serviceFilterForm = document.getElementById('serviceFilterForm');
        if (serviceFilterForm) {
            serviceFilterForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                await applyFilters(HeatmapFilters.getServiceFilters());
            });
        }

        // Botón de reset para reportes
        const resetReportFiltersBtn = document.getElementById('resetReportFilters');
        if (resetReportFiltersBtn) {
            resetReportFiltersBtn.addEventListener('click', () => {
                HeatmapFilters.resetReportFilters();
            });
        }

        // Botón de reset para servicios
        const resetServiceFiltersBtn = document.getElementById('resetServiceFilters');
        if (resetServiceFiltersBtn) {
            resetServiceFiltersBtn.addEventListener('click', () => {
                HeatmapFilters.resetServiceFilters();
            });
        }

        // Selector de tipo de mapa
        const mapTypeSelector = document.getElementById('mapTypeSelector');
        if (mapTypeSelector) {
            mapTypeSelector.addEventListener('change', (e) => {
                const type = e.target.value;
                heatmapManager.setCurrentMapType(type);
                
                if (type === 'reports') {
                    heatmapManager.updateHeatmap(heatmapManager.heatmapData, 'reports');
                    document.getElementById('reportFilters').style.display = 'block';
                    document.getElementById('serviceFilters').style.display = 'none';
                } else {
                    heatmapManager.updateHeatmap(heatmapManager.serviceHeatmapData, 'services');
                    document.getElementById('reportFilters').style.display = 'none';
                    document.getElementById('serviceFilters').style.display = 'block';
                }
            });
        }

        // Actualizar display del rango de horas
        const timeInputs = document.querySelectorAll('input[type="time"]');
        timeInputs.forEach(input => {
            input.addEventListener('change', HeatmapFilters.updateTimeRangeDisplay);
        });
    };

    const applyFilters = async (filters) => {
        try {
            HeatmapUI.showLoading(true);
            const data = await heatmapService.fetchHeatmapData(filters);
            
            if (filters.type === 'services') {
                heatmapManager.serviceHeatmapData = data;
                heatmapManager.setCurrentMapType('services');
            } else {
                heatmapManager.heatmapData = data;
                heatmapManager.setCurrentMapType('reports');
            }
            
            heatmapManager.updateHeatmap(data, filters.type || 'reports');
            HeatmapUI.updatePointsCount(data.length);
        } catch (error) {
            console.error('Error:', error);
            HeatmapUI.showError('Ocurrió un error al cargar los datos. Por favor, intente nuevamente.');
        } finally {
            HeatmapUI.showLoading(false);
        }
    };

    setupEventListeners();
}