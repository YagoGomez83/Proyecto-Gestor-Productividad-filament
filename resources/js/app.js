// resources/js/app.js
import "./bootstrap";
import "tailwindcss/tailwind.css";
import L from 'leaflet';
import 'leaflet.heat';
import Chart from 'chart.js/auto';
import 'leaflet/dist/leaflet.css';
import 'leaflet-control-geocoder/dist/Control.Geocoder.css'; // Importa el CSS del geocodificador
import 'leaflet-control-geocoder';
// Exportar Leaflet y Chart.js al scope global
window.L = L;
window.Leaflet = L;
window.Chart = Chart;
// 1. Importa las imágenes de los marcadores.
// Vite se encargará de proporcionar las rutas correctas a los archivos hasheados.
import iconUrl from 'leaflet/dist/images/marker-icon.png';
import iconRetinaUrl from 'leaflet/dist/images/marker-icon-2x.png'; // Para pantallas de alta resolución
import shadowUrl from 'leaflet/dist/images/marker-shadow.png';

// 2. Reconfigura las opciones de icono por defecto de Leaflet.
// Es una buena práctica borrar _getIconUrl para evitar que Leaflet intente
// adivinar las rutas de los iconos basado en la ubicación del CSS.
delete L.Icon.Default.prototype._getIconUrl;

L.Icon.Default.mergeOptions({
    iconUrl: iconUrl,
    iconRetinaUrl: iconRetinaUrl,
    shadowUrl: shadowUrl,
    // Opcionalmente, puedes especificar los tamaños y puntos de anclaje si los por defecto no son adecuados,
    // pero usualmente no es necesario si estás usando las imágenes estándar de Leaflet.
    // iconSize: [25, 41],
    // iconAnchor: [12, 41],
    // popupAnchor: [1, -34],
    // tooltipAnchor: [16, -28],
    // shadowSize: [41, 41]
});

// 3. Ahora puedes inicializar tu mapa y añadir marcadores como de costumbre.
// Este código puede estar en el mismo archivo o en otro que se cargue después de esta configuración.
// Ejemplo:

// // Importar e inicializar heatmap
// import initializeHeatmap from './heatmap/initHeatmap';

// // Función para inicializar mapas
// window.initMap = function(mapId, center = [-33.2951, -66.3379], zoom = 14) {
//     if (!window.L) {
//         console.error('Leaflet no está disponible');
//         return null;
//     }

//     const map = L.map(mapId).setView(center, zoom);
    
//     L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
//         attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
//     }).addTo(map);

//     return map;
// };

// // Exportar la función de heatmap al scope global si es necesario
// window.initializeHeatmap = initializeHeatmap;

// console.log('Aplicación inicializada:', { L, Chart, initializeHeatmap });