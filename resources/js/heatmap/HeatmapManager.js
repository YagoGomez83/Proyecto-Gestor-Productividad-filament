// resources/js/heatmap/HeatmapManager.js
export default class HeatmapManager {
    constructor() {
        this.map = null;
        this.heatmapLayer = null;
        this.serviceHeatmapLayer = null;
        this.defaultBounds = null;
        this.currentMapType = 'reports';
        this.heatmapData = [];
        this.serviceHeatmapData = [];
    }

    initMap(containerId, initialData) {
        // Centro inicial basado en los datos de reportes
        const centerLat = initialData.length > 0 ?
            initialData.reduce((sum, point) => sum + point.lat, 0) / initialData.length : -34.6037;
        const centerLng = initialData.length > 0 ?
            initialData.reduce((sum, point) => sum + point.lng, 0) / initialData.length : -58.3816;

        this.map = L.map(containerId).setView([centerLat, centerLng], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 19
        }).addTo(this.map);

        // Guardar los límites iniciales
        if (initialData.length > 0) {
            const points = initialData.map(point => [point.lat, point.lng]);
            this.defaultBounds = L.latLngBounds(points);
        }
    }

    updateHeatmap(data, type = this.currentMapType) {
        // Verificar si data es válido
        if (!data || !Array.isArray(data)) {
            console.error('Datos no válidos para el mapa de calor:', data);
            data = [];
        }

        // Eliminar capa de calor existente si hay una
        if (type === 'reports' && this.heatmapLayer) {
            this.map.removeLayer(this.heatmapLayer);
        } else if (type === 'services' && this.serviceHeatmapLayer) {
            this.map.removeLayer(this.serviceHeatmapLayer);
        }

        if (data.length > 0) {
            const points = data.map(point => [point.lat, point.lng, point.intensity || 1]);

            if (type === 'reports') {
                this.heatmapLayer = L.heatLayer(points, {
                    radius: 25,
                    blur: 15,
                    maxZoom: 17,
                    minOpacity: 0.5,
                    gradient: {
                        0.4: 'blue',
                        0.6: 'cyan',
                        0.7: 'lime',
                        0.8: 'yellow',
                        1.0: 'red'
                    }
                }).addTo(this.map);
            } else {
                this.serviceHeatmapLayer = L.heatLayer(points, {
                    radius: 25,
                    blur: 15,
                    maxZoom: 17,
                    minOpacity: 0.5,
                    gradient: {
                        0.4: 'purple',
                        0.6: 'indigo',
                        0.7: 'pink',
                        0.8: 'orange',
                        1.0: 'darkred'
                    }
                }).addTo(this.map);
            }

            // Ajustar la vista
            const bounds = L.latLngBounds(points.map(p => [p[0], p[1]]));
            this.map.fitBounds(bounds);
        } else {
            this.showNoDataMessage();
        }
    }

    showNoDataMessage() {
        if (this.defaultBounds) {
            this.map.fitBounds(this.defaultBounds);
        } else {
            this.map.setView([-34.6037, -58.3816], 13);
        }

        L.popup()
            .setLatLng(this.map.getCenter())
            .setContent('No hay datos que coincidan con los filtros seleccionados')
            .openOn(this.map);
    }

    setCurrentMapType(type) {
        this.currentMapType = type;
    }
    updateHeatmap(data, type = this.currentMapType) {
        // Verificar si data es válido
        if (!data || !Array.isArray(data)) {
            console.error('Datos no válidos para el mapa de calor:', data);
            data = [];
        }
    
        // Eliminar capa de calor existente si hay una
        if (type === 'reports' && this.heatmapLayer) {
            this.map.removeLayer(this.heatmapLayer);
        } else if (type === 'services' && this.serviceHeatmapLayer) {
            this.map.removeLayer(this.serviceHeatmapLayer);
        }
    
        if (data.length > 0) {
            const points = data.map(point => {
                // Para servicios, usamos count como intensidad, para reportes 1
                const intensity = type === 'services' ? point.count || point.intensity : point.intensity || 1;
                return [point.lat, point.lng, intensity];
            });
    
            if (type === 'reports') {
                this.heatmapLayer = L.heatLayer(points, {
                    radius: 25,
                    blur: 15,
                    maxZoom: 17,
                    minOpacity: 0.5,
                    gradient: {
                        0.4: 'blue',
                        0.6: 'cyan',
                        0.7: 'lime',
                        0.8: 'yellow',
                        1.0: 'red'
                    }
                }).addTo(this.map);
            } else {
                this.serviceHeatmapLayer = L.heatLayer(points, {
                    radius: 25,
                    blur: 15,
                    maxZoom: 17,
                    minOpacity: 0.5,
                    gradient: {
                        0.4: 'purple',
                        0.6: 'indigo',
                        0.7: 'pink',
                        0.8: 'orange',
                        1.0: 'darkred'
                    }
                }).addTo(this.map);
    
                // Agregar popups para servicios
                data.forEach(service => {
                    const marker = L.marker([service.lat, service.lng])
                        .bindPopup(`
                            <b>Cámara:</b> ${service.camera_identifier || 'N/A'}<br>
                            <b>Servicios:</b> ${service.count}<br>
                            <b>Tipo:</b> ${service.type === 'P' ? 'Preventivo' : 'Reactivo'}
                        `)
                        .addTo(this.map);
                });
            }
    
            // Ajustar la vista
            const bounds = L.latLngBounds(points.map(p => [p[0], p[1]]));
            this.map.fitBounds(bounds);
        } else {
            this.showNoDataMessage();
        }
    }
}