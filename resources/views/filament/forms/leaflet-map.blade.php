@extends('layouts.app')

@section('content')
<div wire:ignore class="relative w-full h-96">
    <div id="map" class="w-full h-full rounded-lg border"></div>
</div>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Asignar latitudes y longitudes desde Livewire (o valores por defecto)
    var lat = @json($latitude ?? -33.2975);
    var lng = @json($longitude ?? -66.3356);
console.log("latitud:", lat);
console.log("longitud:", lng);
console.log("address:", @json($latitude));
console.log("address:", @json($longitude));

    // Inicializar mapa con Leaflet
    var map = L.map('map').setView([lat, lng], 16);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Inicializar marcador en el mapa
    var marker = L.marker([lat, lng], { draggable: true }).addTo(map);

    // Escuchar el evento 'setLocation' de Livewire
    Livewire.on('setLocation', (latitude, longitude, address) => {
        console.log("Evento setLocation recibido:", latitude, longitude, address);
        // Actualizar la posición del marcador y el mapa
        marker.setLatLng([latitude, longitude]);
        map.setView([latitude, longitude], 16);
        if (address) {
            // Aquí puedes manejar la dirección si la necesitas
            console.log('Dirección:', address);
        }
    });

    // Al mover el marcador, obtener la nueva posición y actualizar la dirección
    marker.on('dragend', function (e) {
        var lat = marker.getLatLng().lat;
        var lng = marker.getLatLng().lng;

        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
            .then(response => response.json())
            .then(data => {
                var address = data.display_name || "Ubicación desconocida";

                // Actualizar los valores en Livewire
                @this.set('latitude', lat);
                @this.set('longitude', lng);
                @this.set('address', address);

                // Emitir evento a Livewire con la nueva ubicación
                Livewire.emit('setLocation', lat, lng, address);
            });
    });

    // Emitir evento para actualizar el mapa cuando se carga la vista
    if (@this.record) {
        console.log("Ubicación actual:", @this.record.latitude, @this.record.longitude);
        // Si estamos editando
        Livewire.emit('setLocation', lat, lng, null);
    } else {
        console.log("creando el mapa cuando se carga la vista");
        // Si estamos creando
        Livewire.emit('setLocation', lat, lng, null);
    }
});

</script>
@endpush

@endsection
