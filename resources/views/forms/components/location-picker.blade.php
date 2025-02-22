<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div x-data="mapHandler()" x-init="initMap()" class="w-full h-64">
        <div id="map" style="height: 100%;"></div>
    </div>

    <script>
        function mapHandler() {
            return {
                latitude: @js($latitude ?? 0),
                longitude: @js($longitude ?? 0),
                map: null,
                marker: null,

                initMap() {
                    this.map = L.map('map').setView([this.latitude, this.longitude], 13);
                    
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; OpenStreetMap contributors'
                    }).addTo(this.map);

                    this.marker = L.marker([this.latitude, this.longitude], { draggable: true }).addTo(this.map);

                    this.marker.on('dragend', (event) => {
                        let position = event.target.getLatLng();
                        this.latitude = position.lat;
                        this.longitude = position.lng;
                    });

                    this.map.on('click', (event) => {
                        let position = event.latlng;
                        this.marker.setLatLng(position);
                        this.latitude = position.lat;
                        this.longitude = position.lng;
                    });
                }
            };
        }
    </script>
</x-dynamic-component>
