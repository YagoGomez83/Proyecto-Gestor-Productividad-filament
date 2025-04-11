<div id="{{ $mapId }}" style="height: {{ $mapHeight }}; width: 100%;"></div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const map = L.map('{{ $mapId }}').setView([{{ $defaultLat }}, {{ $defaultLng }}], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        const heatData = @json($heatData);

        // Heatmap difuso en escala violeta
        const heatmapLayer = L.heatLayer(
            heatData.map(point => [point.lat, point.lng, point.intensity || 0.5]), {
                radius: {{ $radius }},
                blur: {{ $blur }},
                minOpacity: {{ $minOpacity }},
                gradient: {
                    0.0: '#f3e5f5',  // violeta muy claro
                    0.3: '#ce93d8',  // lila
                    0.6: '#ba68c8',  // violeta
                    0.9: '#8e24aa',  // púrpura
                    1.0: '#4a148c'   // violeta oscuro intenso
                }
            }
        ).addTo(map);

        // Función para obtener color violeta degradado según intensidad
        function getVioletGradientColor(intensity) {
            const minColor = [238, 130, 238]; // #EE82EE
            const maxColor = [74, 20, 140];   // #4a148c

            const r = Math.round(minColor[0] + (maxColor[0] - minColor[0]) * intensity);
            const g = Math.round(minColor[1] + (maxColor[1] - minColor[1]) * intensity);
            const b = Math.round(minColor[2] + (maxColor[2] - minColor[2]) * intensity);

            return `rgb(${r}, ${g}, ${b})`;
        }

        // Agregar marcadores con popup (pueden ser opcionales si solo querés heatmap visual)
        heatData.forEach(point => {
            const marker = L.circleMarker([point.lat, point.lng], {
                radius: {{ $markerRadius }},
                fillColor: getVioletGradientColor(point.intensity || 0.5),
                color: "#000",
                weight: 0.5,
                opacity: 0.6,
                fillOpacity: 0.4 // menor opacidad para efecto más suave
            }).addTo(map);

            const popupContent = `
                <strong>${point.title}</strong><br>
                Causa: ${point.cause}<br>
                Descripción: ${point.description}<br>
                Comisaría: ${point.station}<br>
                Ciudad: ${point.city}
            `;
            marker.bindPopup(popupContent);
        });
    });
</script>
@endpush

