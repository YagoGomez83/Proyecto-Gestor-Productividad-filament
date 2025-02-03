<div x-data="locationPicker()">
    <!-- Contenedor del mapa de Leaflet -->
    <div id="map" style="height: 300px; width: 100%;"></div>

    <!-- Campos ocultos para almacenar la latitud y longitud -->
    <input type="hidden" name="{{ $getLatitudeField() }}" x-model="latitude" />
    <input type="hidden" name="{{ $getLongitudeField() }}" x-model="longitude" />
</div>

<script>
    function locationPicker() {
        return {
            // Variables reactivas para almacenar la latitud y longitud
            latitude: @entangle($getLatitudeField()),
            longitude: @entangle($getLongitudeField()),

            // Método que se ejecuta al inicializar el componente
            init() {
                // Inicializa el mapa de Leaflet
                const map = L.map('map').setView([0, 0], 2);

                // Añade una capa de mapa base (OpenStreetMap)
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);

                // Crea un marcador arrastrable en el mapa
                const marker = L.marker([0, 0], { draggable: true }).addTo(map);

                // Escucha el evento de arrastre del marcador
                marker.on('dragend', (e) => {
                    const { lat, lng } = e.target.getLatLng();
                    // Actualiza la latitud y longitud
                    this.latitude = lat;
                    this.longitude = lng;
                });

                // Si ya hay una ubicación seleccionada, coloca el marcador en esa posición
                if (this.latitude && this.longitude) {
                    marker.setLatLng([this.latitude, this.longitude]);
                    map.setView([this.latitude, this.longitude], 15); // Centra el mapa en la ubicación seleccionada
                }
            }
        };
    }
</script>