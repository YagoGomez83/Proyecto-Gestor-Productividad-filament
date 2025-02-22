@extends('layouts.app')

@section('content')
<div wire:ignore class="relative w-full h-96">
    <div id="map" class="w-full h-full rounded-lg border"></div>
</div>

<script>
    document.addEventListener('livewire:load', function () {
        let map = L.map('map').setView([{{ $latitude ?? -33.2975 }}, {{ $longitude ?? -66.3356 }}], 16);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        var marker = L.marker([{{ $latitude ?? -33.2975 }}, {{ $longitude ?? -66.3356 }}], { draggable: true }).addTo(map);

        marker.on('dragend', function (e) {
            var lat = marker.getLatLng().lat;
            var lng = marker.getLatLng().lng;

            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                .then(response => response.json())
                .then(data => {
                    var address = data.display_name || "Ubicación desconocida";

                    // Emitir el evento 'setLocation' a Livewire
                    Livewire.emit('setLocation', lat, lng, address);
                })
                .catch(error => console.error('Error obteniendo la dirección:', error));
        });
    });
</script>
@endsection
