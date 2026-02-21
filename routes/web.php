<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Master Data Routes
    Route::prefix('admin/master')->name('admin.master.')->group(function () {
        Route::resource('jenis-surat', \App\Http\Controllers\Admin\JenisSuratController::class);
        Route::resource('wilayah', \App\Http\Controllers\Admin\MasterWilayahController::class);
        Route::resource('agama', \App\Http\Controllers\Admin\MasterAgamaController::class);
        Route::resource('pekerjaan', \App\Http\Controllers\Admin\MasterPekerjaanController::class);
        Route::resource('jabatan', \App\Http\Controllers\Admin\MasterJabatanController::class);
        Route::resource('pejabat-desa', \App\Http\Controllers\Admin\PejabatDesaController::class);
        Route::resource('penduduk', \App\Http\Controllers\Admin\PendudukController::class);
        Route::resource('priority-bobot', \App\Http\Controllers\Admin\PriorityBobotController::class);
    });
});

require __DIR__ . '/auth.php';
