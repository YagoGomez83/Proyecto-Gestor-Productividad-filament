<?php

use App\Http\Controllers\CameraController;
use Illuminate\Support\Facades\Route;

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
    return redirect('/operator');
});

Route::middleware(['auth', 'role:coordinator'])->group(function () {
    Route::get('/admin/cameras/custom', [CameraController::class, 'index'])->name('cameras.custom');
    Route::get('/admin/camera/create', [CameraController::class, 'create'])->name('camera.create');
    Route::post('/admin/camera/store', [CameraController::class, 'store'])->name('cameras.store');
    Route::get('/admin/camara/edit/{id}', [CameraController::class, 'edit'])->name('camera.editar');
    Route::put('/admin/camara/update/{id}', [CameraController::class, 'update'])->name('camera.update');
    Route::delete('/admin/camara/delete/{id}', [CameraController::class, 'destroy'])->name('camera.delete');
    Route::get('/admin/camera/{id}', [CameraController::class, 'show'])->name('camera.show');
    Route::get('admin/cameras/deleted', [CameraController::class, 'deteledCameras'])->name('cameras.deleted');
    Route::post('/admin/camara/restore/{id}', [CameraController::class, 'restoreCamera'])->name('camera.restore');
});
