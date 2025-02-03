@extends('layouts.app') {{-- O el layout que estés usando --}}

@section('content')
    <div>
        <form wire:submit.prevent="save">
            <div class="mb-4">
                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                <input type="text" wire:model="address" id="address" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div class="mb-4">
                <label for="latitude" class="block text-sm font-medium text-gray-700">Latitude</label>
                <input type="text" wire:model="latitude" id="latitude" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div class="mb-4">
                <label for="longitude" class="block text-sm font-medium text-gray-700">Longitude</label>
                <input type="text" wire:model="longitude" id="longitude" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Save Location</button>
        </form>

        <div id="map" class="mt-4" style="height: 400px;"></div>

        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    console.log('Página cargada, inicializando mapa...');

                    var initialLat = -33.2951;
                    var initialLng = -66.3379;

                    var map = L.map('map').setView([initialLat, initialLng], 14);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OpenStreetMap contributors'
                    }).addTo(map);

                    var marker = L.marker([initialLat, initialLng], { draggable: true }).addTo(map);

                    console.log('Mapa inicializado correctamente.');

                    function updateLocation(lat, lng) {
                        console.log(`Ubicación actualizada: Lat: ${lat}, Lng: ${lng}`);
                        Livewire.emit('updateLocation', lat, lng);

                        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                            .then(response => response.json())
                            .then(data => {
                                let address = data.display_name || 'Dirección no encontrada';
                                console.log(`Dirección encontrada: ${address}`);
                                Livewire.emit('updateAddress', address);
                            })
                            .catch(error => console.error('Error obteniendo dirección:', error));
                    }

                    marker.on('dragend', function (e) {
                        var position = marker.getLatLng();
                        updateLocation(position.lat, position.lng);
                    });

                    Livewire.on('updateLocation', (lat, lng) => {
                        marker.setLatLng([lat, lng]);
                        map.setView([lat, lng], 14);
                    });

                    updateLocation(initialLat, initialLng);
                });
            </script>
        @endpush
    </div>
@endsection
