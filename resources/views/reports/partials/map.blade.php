<div id="heatmapContainer" class="h-[600px] rounded-lg border border-gray-300"></div>

@push('scripts')
<script>
    // Pasar datos iniciales al JS
    window.heatmapData = @json($reports->map(function($report) {
        return [
            'lat' => $report->location->latitude,
            'lng' => $report->location->longitude,
            'cause_id' => $report->cause_id,
            'police_station_id' => $report->police_station_id,
            'report_date' => $report->report_date,
            'report_time' => $report->report_time,
            'intensity' => 1 // Puedes ajustar esto según necesidades
        ];
    }));
</script>
@endpush