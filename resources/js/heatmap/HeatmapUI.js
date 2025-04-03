// resources/js/heatmap/HeatmapUI.js
export default class HeatmapUI {
    static showLoading(show) {
        const loadingSpinner = document.getElementById('loadingSpinner');
        const buttons = document.querySelectorAll('#filterForm button, #serviceFilterForm button');

        buttons.forEach(button => {
            button.disabled = show;
        });

        loadingSpinner.style.display = show ? 'block' : 'none';
    }

    static updatePointsCount(count) {
        document.getElementById('pointsCount').textContent = count;
    }

    static setActiveMapButton(type) {
        if (type === 'reports') {
            document.getElementById('showReportsBtn').classList.add('bg-blue-700');
            document.getElementById('showServicesBtn').classList.remove('bg-green-700');
        } else {
            document.getElementById('showServicesBtn').classList.add('bg-green-700');
            document.getElementById('showReportsBtn').classList.remove('bg-blue-700');
        }
    }

    static showError(message) {
        alert(message);
    }
}