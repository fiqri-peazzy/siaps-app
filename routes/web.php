<?php

use App\Http\Controllers\Auth\PhoneAuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\PengajuanAdminController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/profil-desa', [PublicController::class, 'profil'])->name('public.profil');
Route::get('/layanan', [PublicController::class, 'layanan'])->name('public.layanan');
Route::get('/informasi', [PublicController::class, 'informasi'])->name('public.informasi');
Route::get('/informasi/{slug}', [PublicController::class, 'showInformasi'])->name('public.informasi.show');

/*
|--------------------------------------------------------------------------
| Auth Masyarakat (Phone + OTP)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->prefix('login')->name('auth.')->group(function () {
    Route::get('/phone', [PhoneAuthController::class, 'showPhoneForm'])->name('phone');
    Route::post('/send-otp', [PhoneAuthController::class, 'sendOtp'])->name('otp.send');
    Route::get('/verify', [PhoneAuthController::class, 'showOtpForm'])->name('otp.form');
    Route::post('/verify', [PhoneAuthController::class, 'verifyOtp'])->name('otp.verify');
    Route::post('/resend', [PhoneAuthController::class, 'resendOtp'])->name('otp.resend');
    Route::post('/logout', [PhoneAuthController::class, 'logout'])->name('logout')->withoutMiddleware('guest')->middleware('auth');
});

/*
|--------------------------------------------------------------------------
| Masyarakat Dashboard (Authenticated)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'masyarakat'])->prefix('akun')->name('masyarakat.')->group(function () {
    Route::get('/home', function () {
        return view('masyarakat.home');
    })->name('home');

    // Biodata
    Route::get('/profile', [\App\Http\Controllers\Masyarakat\BiodataController::class, 'index'])->name('profile');
    Route::post('/profile', [\App\Http\Controllers\Masyarakat\BiodataController::class, 'update'])->name('profile.update');

    // Pengajuan Surat
    Route::prefix('pengajuan')->name('pengajuan.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Masyarakat\PengajuanController::class, 'index'])->name('index');
        Route::get('/tambah/{jenis_surat:kode}', [\App\Http\Controllers\Masyarakat\PengajuanController::class, 'create'])->name('create');
        Route::post('/tambah/{jenis_surat:kode}', [\App\Http\Controllers\Masyarakat\PengajuanController::class, 'store'])->name('store');
        Route::get('/{pengajuan:kode_pengajuan}', [\App\Http\Controllers\Masyarakat\PengajuanController::class, 'show'])->name('show');
    });
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        if (Auth::user()->role === 'masyarakat') {
            return redirect()->route('masyarakat.home');
        }
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Master Data
    Route::prefix('admin')->name('admin.')->group(function () {
        // Biodata Validation
        Route::controller(\App\Http\Controllers\Admin\BiodataValidationController::class)->prefix('validation')->name('biodata-validation.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{biodata}', 'show')->name('show');
            Route::post('/{biodata}/approve', 'approve')->name('approve');
            Route::post('/{biodata}/reject', 'reject')->name('reject');
        });

        // Pengajuan Management (DPS)
        Route::controller(\App\Http\Controllers\Admin\PengajuanAdminController::class)->prefix('pengajuan')->name('pengajuan.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{pengajuan}', 'show')->name('show');
            Route::post('/{pengajuan}/process', 'process')->name('process');
            Route::post('/{pengajuan}/approve', 'approve')->name('approve');
            Route::post('/{pengajuan}/reject', 'reject')->name('reject');
        });

        Route::prefix('master')->name('master.')->group(function () {
            Route::resource('jenis-surat', \App\Http\Controllers\Admin\JenisSuratController::class);
            Route::resource('wilayah', \App\Http\Controllers\Admin\MasterWilayahController::class);
            Route::resource('agama', \App\Http\Controllers\Admin\MasterAgamaController::class);
            Route::resource('pekerjaan', \App\Http\Controllers\Admin\MasterPekerjaanController::class);
            Route::resource('jabatan', \App\Http\Controllers\Admin\MasterJabatanController::class);
            Route::resource('pejabat-desa', \App\Http\Controllers\Admin\PejabatDesaController::class);
            Route::resource('penduduk', \App\Http\Controllers\Admin\PendudukController::class);
            Route::resource('priority-bobot', \App\Http\Controllers\Admin\PriorityBobotController::class);
        });

        // Admin CMS
        Route::prefix('cms')->name('cms.')->group(function () {
            Route::get('profil-desa', [\App\Http\Controllers\Admin\ProfilDesaController::class, 'index'])->name('profil-desa.index');
            Route::put('profil-desa', [\App\Http\Controllers\Admin\ProfilDesaController::class, 'update'])->name('profil-desa.update');
            Route::resource('informasi', \App\Http\Controllers\Admin\InformasiDesaController::class);
        });
    });
});

require __DIR__ . '/auth.php';
