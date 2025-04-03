// resources/js/heatmap/HeatmapService.js
export default class HeatmapService {
    constructor(route) {
        this.route = route;
    }

    async fetchHeatmapData(filters = {}) {
        const queryParams = new URLSearchParams();
        
        // Agregar todos los parámetros posibles
        Object.keys(filters).forEach(key => {
            if (filters[key]) queryParams.append(key, filters[key]);
        });

        try {
            const response = await fetch(`${this.route}?${queryParams.toString()}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.ok) throw new Error('Error en la respuesta del servidor');
            
            return await response.json();
        } catch (error) {
            console.error('Error fetching heatmap data:', error);
            throw error;
        }
    }
}