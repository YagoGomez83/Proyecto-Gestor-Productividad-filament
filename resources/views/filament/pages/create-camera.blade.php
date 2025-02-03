<x-filament-panels::page>
    <!-- Formulario de creación de cámara -->
    <div class="space-y-6">
        <x-filament::form :action="route('filament.resources.cameras.store')" method="POST">
            <!-- Otros campos del formulario -->
            <div id="map" style="height: 400px;"></div>

            <!-- Campos ocultos para latitud, longitud y dirección -->
            <input type="hidden" name="latitude" value="{{ old('latitude') }}">
            <input type="hidden" name="longitude" value="{{ old('longitude') }}">
            <input type="text" name="address" value="{{ old('address') }}" class="mt-2 w-full rounded-md border-gray-300" placeholder="Dirección" readonly>

            <div class="mt-4">
                <x-filament::button>Guardar</x-filament::button>
            </div>
        </x-filament::form>
    </div>
</x-filament-panels::page>

@push('scripts')
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var map = L.map('map').setView([10.0000, -84.0000], 6); // Establece la vista del mapa en un punto inicial

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            var marker = L.marker([10.0000, -84.0000], { draggable: true }).addTo(map);

            marker.on('dragend', function (e) {
                var lat = marker.getLatLng().lat;
                var lng = marker.getLatLng().lng;

                // Llenar los campos del formulario con los valores de latitud, longitud y dirección
                document.querySelector('input[name="latitude"]').value = lat;
                document.querySelector('input[name="longitude"]').value = lng;

                // Obtener dirección usando la API de OpenStreetMap
                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                    .then(response => response.json())
                    .then(data => {
                        document.querySelector('input[name="address"]').value = data.display_name || "Ubicación desconocida";
                    });
            });
        });
    </script>
@endpush
