// resources/js/app.js
import "./bootstrap";
import "tailwindcss/tailwind.css";
import L from 'leaflet';
import 'leaflet.heat';
import Chart from 'chart.js/auto';
import 'leaflet/dist/leaflet.css';

// Exportar Leaflet y Chart.js al scope global
window.L = L;
window.Leaflet = L;
window.Chart = Chart;

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