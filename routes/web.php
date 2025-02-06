<?php

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
