<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EvaluasiController;
use App\Http\Controllers\EvaluatorController;
use App\Http\Controllers\InstrumenController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\PohonKinerjaController;
use App\Http\Controllers\RealisasiController;
use App\Http\Controllers\UnitKerjaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->role === 'tim_sakip') {
            return redirect()->route('dashboard.tim_sakip');
        } elseif ($user->role === 'unit_kerja') {
            return redirect()->route('dashboard.unit_kerja');
        } elseif ($user->role === 'evaluator') {
            return redirect()->route('dashboard.evaluator');
        }
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
})->name('home');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard routes (protected)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/tim-sakip', [DashboardController::class, 'timSakip'])->name('dashboard.tim_sakip');
    Route::get('/dashboard/unit-kerja', [DashboardController::class, 'unitKerja'])->name('dashboard.unit_kerja');
    Route::get('/dashboard/evaluator', [DashboardController::class, 'evaluator'])->name('dashboard.evaluator');

    Route::get('/profile/edit', [DashboardController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile/update', [DashboardController::class, 'updateProfile'])->name('profile.update');

    // Satu baris ini otomatis membuat 7 route untuk CRUD Instrumen
    Route::get('/instrumen', [InstrumenController::class, 'index'])->name('instrumen.index');
    Route::get('/instrumen/create', [InstrumenController::class, 'create'])->name('instrumen.create');
    Route::post('/instrumen', [InstrumenController::class, 'store'])->name('instrumen.store');
    Route::get('/instrumen/{instrumen}/edit', [InstrumenController::class, 'edit'])->name('instrumen.edit');
    Route::put('/instrumen/{instrumen}', [InstrumenController::class, 'update'])->name('instrumen.update');
    Route::delete('/instrumen/{instrumen}', [InstrumenController::class, 'destroy'])->name('instrumen.destroy');
    // Route::resource('instrumen', InstrumenController::class);

    // PINDAHKAN ROUTE POHON KINERJA KE SINI
    Route::get('/pohon-kinerja', [PohonKinerjaController::class, 'index'])->name('pohon-kinerja.index');

    // Route untuk menampilkan form tambah data
    Route::get('/pohon-kinerja/create', [PohonKinerjaController::class, 'create'])->name('pohon-kinerja.create');

    // Route untuk menyimpan data baru
    Route::post('/pohon-kinerja', [PohonKinerjaController::class, 'store'])->name('pohon-kinerja.store');

    // Route untuk menampilkan form edit
    Route::get('/pohon-kinerja/{pohonKinerja}/edit', [PohonKinerjaController::class, 'edit'])->name('pohon-kinerja.edit');

    // Route untuk memproses update data
    Route::put('/pohon-kinerja/{pohonKinerja}', [PohonKinerjaController::class, 'update'])->name('pohon-kinerja.update');

    // Route untuk memproses penghapusan data
    Route::delete('/pohon-kinerja/{pohonKinerja}', [PohonKinerjaController::class, 'destroy'])->name('pohon-kinerja.destroy');

    // Route untuk menampilkan detail pohon kinerja
    Route::get('/pohon-kinerja/{pohonKinerja}', [PohonKinerjaController::class, 'show'])->name('pohon-kinerja.show');


    // Route untuk menampilkan halaman form assignment
    Route::get('/pohon-kinerja/{pohonKinerja}/assign', [PohonKinerjaController::class, 'showAssignForm'])->name('pohon-kinerja.assign.show');

    // Route untuk memproses/menyimpan assignment
    Route::post('/pohon-kinerja/{pohonKinerja}/assign', [PohonKinerjaController::class, 'syncAssignments'])->name('pohon-kinerja.assign.sync');

    // --- Route untuk Modul Pelaporan Realisasi ---
    // Halaman utama yang berisi daftar tugas unit kerja
    Route::get('/realisasi', [RealisasiController::class, 'index'])->name('realisasi.index');
    // Halaman form untuk mengisi laporan
    Route::get('/realisasi/lapor/{pohonKinerja}/{tahun}', [RealisasiController::class, 'create'])->name('realisasi.create');

    // Proses penyimpanan laporan
    Route::post('/realisasi', [RealisasiController::class, 'store'])->name('realisasi.store');

    // ROUTE BARU UNTUK EDIT DAN UPDATE
    Route::get('/realisasi/{realisasi}/edit', [RealisasiController::class, 'edit'])->name('realisasi.edit');
    Route::put('/realisasi/{realisasi}', [RealisasiController::class, 'update'])->name('realisasi.update');


    // Route untuk Halaman Monitoring Laporan
    Route::get('/monitoring-laporan', [MonitoringController::class, 'index'])->name('monitoring.laporan.index');

    // Route untuk CRUD User
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    // Route::resource('users', UserController::class);


    // Route untuk CRUD Unit Kerja
    Route::get('/unit-kerja', [UnitKerjaController::class, 'index'])->name('unit-kerja.index');
    Route::get('/unit-kerja/create', [UnitKerjaController::class, 'create'])->name('unit-kerja.create');
    Route::post('/unit-kerja', [UnitKerjaController::class, 'store'])->name('unit-kerja.store');
    Route::get('/unit-kerja/{unitKerja}/edit', [UnitKerjaController::class, 'edit'])->name('unit-kerja.edit');
    Route::put('/unit-kerja/{unitKerja}', [UnitKerjaController::class, 'update'])->name('unit-kerja.update');
    Route::delete('/unit-kerja/{unitKerja}', [UnitKerjaController::class, 'destroy'])->name('unit-kerja.destroy');
    // Route::resource('unit-kerja', UnitKerjaController::class);

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export', [LaporanController::class, 'export'])->name('laporan.export');

    Route::post('/evaluasi-laporan', [EvaluasiController::class, 'store'])->name('evaluasi.store');
    Route::get('/realisasi/{realisasi}', [RealisasiController::class, 'show'])->name('realisasi.show');

    Route::put('/evaluasi-laporan/{evaluasiLaporan}', [EvaluasiController::class, 'update'])->name('evaluasi.update');
    Route::delete('/evaluasi-laporan/{evaluasiLaporan}', [EvaluasiController::class, 'destroy'])->name('evaluasi.destroy');

    Route::get('/evaluator/dashboard', [EvaluatorController::class, 'dashboard'])->name('evaluator.dashboard');
});
