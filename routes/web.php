<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CameraController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\HeatmapController;
use App\Http\Controllers\CameraHeatmapController;
use App\Http\Controllers\ServiceHeatmapController;

// Route::view('/', 'public.index')->name('welcome');

// Route::get('/admin', function () {
//     $user = auth()->user();

//     if ($user->hasRole(['admin', 'coordinator'])) {
//         return redirect('/admin');
//     } elseif ($user->hasRole('supervisor')) {
//         return redirect('/supervisor');
//     } elseif ($user->hasRole('operator')) {
//         return redirect('/operator');
//     }

//     return abort(403);
// })->middleware('auth')->name('dashboard');
Route::get('/', function () {
    return view('public.home');
})->name('home');

Route::middleware(['auth', 'role:coordinator|supervisor'])->group(function () {
    Route::get('/admin/cameras/custom', [CameraController::class, 'index'])->name('cameras.custom');
    Route::get('/admin/camera/create', [CameraController::class, 'create'])->name('camera.create');
    Route::post('/admin/camera/store', [CameraController::class, 'store'])->name('cameras.store');
    Route::get('/admin/camara/edit/{id}', [CameraController::class, 'edit'])->name('camera.editar');
    Route::put('/admin/camara/update/{id}', [CameraController::class, 'update'])->name('camera.update');
    Route::delete('/admin/camara/delete/{id}', [CameraController::class, 'destroy'])->name('camera.delete');
    Route::get('/admin/camera/{id}', [CameraController::class, 'show'])->name('camera.show');
    Route::get('admin/cameras/deleted', [CameraController::class, 'deteledCameras'])->name('cameras.deleted');
    Route::post('/admin/camara/restore/{id}', [CameraController::class, 'restoreCamera'])->name('camera.restore');

    //Reports routes

    Route::get('/admin/reports/custom', [ReportController::class, 'index'])->name('reports.custom');
    Route::get('/admin/report/create', [ReportController::class, 'create'])->name('report.create');
    Route::post('/admin/report/store', [ReportController::class, 'store'])->name('reports.store');
    Route::get('/admin/report/edit/{id}', [ReportController::class, 'edit'])->name('report.editar');
    Route::put('/admin/report/update/{id}', [ReportController::class, 'update'])->name('report.update');
    Route::delete('/admin/report/delete/{id}', [ReportController::class, 'destroy'])->name('report.delete');
    Route::get('/admin/report/{id}', [ReportController::class, 'show'])->name('report.show');
    Route::get('admin/reports/deleted', [ReportController::class, 'deteledReports'])->name('reports.deleted');
    Route::post('/admin/report/restore/{id}', [ReportController::class, 'restoreReport'])->name('report.restore');
    // Mapa de calor
    Route::get('/heatmap', [HeatmapController::class, 'index'])->name('heatmap.index');
    Route::get('/api/heatmap-data', [HeatmapController::class, 'getHeatmapData'])->name('heatmap.data');
    Route::get('/heatmap/services', [ServiceHeatmapController::class, 'index'])->name('heatmap.services');
    Route::get('/api/heatmap-services-data', [ServiceHeatmapController::class, 'getHeatmapData'])->name('heatmap.services.data');
   
});
