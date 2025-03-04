<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\KunjunganController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\LaboratoriumController;
use App\Http\Controllers\RadiologiController;
use App\Http\Controllers\ApotekController;
use App\Http\Controllers\HRDController;
use App\Http\Controllers\SuppliesController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\LainnyaController;

// Route untuk halaman awal dan login tidak perlu auth
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route untuk autentikasi (tanpa middleware guest)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Route yang memerlukan auth
Route::middleware(['web', 'auth'])->group(function() {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Routes untuk menu navbar
    Route::get('/kunjungan', [KunjunganController::class, 'index'])->name('kunjungan');
    Route::get('/keuangan', [KeuanganController::class, 'index'])->name('keuangan');
    Route::get('/apotek', [ApotekController::class, 'index'])->name('apotek');
    Route::get('/hrd', [HRDController::class, 'index'])->name('hrd');

    // Laporan routes
    Route::get('/laporan-keuangan', [KeuanganController::class, 'index'])->name('laporan.keuangan');
    Route::get('/laporan-kunjungan', [KunjunganController::class, 'index'])->name('laporan.kunjungan');
    Route::get('/laporan-obat', [ObatController::class, 'index'])->name('laporan.obat');
    Route::get('/laporan-laboratorium', [LaboratoriumController::class, 'index'])->name('laporan.laboratorium');
    Route::get('/laporan-radiologi', [RadiologiController::class, 'index'])->name('laporan.radiologi');

    // Tambahkan route baru
    Route::get('/supplies', [SuppliesController::class, 'index'])->name('supplies');
    Route::get('/layanan', [LayananController::class, 'index'])->name('layanan');
    Route::get('/lainnya', [LainnyaController::class, 'index'])->name('lainnya');

    // Routes untuk menu keuangan
    Route::prefix('keuangan')->group(function () {
        Route::get('/dashboard', [KeuanganController::class, 'dashboard'])->name('keuangan.dashboard');
        Route::get('/arus-kas', [KeuanganController::class, 'getArusKasData'])->name('keuangan.arus-kas');
        Route::get('/buku-kas', [KeuanganController::class, 'bukukas'])->name('keuangan.bukukas');
        Route::get('/penerimaan', [KeuanganController::class, 'penerimaan'])->name('keuangan.penerimaan');
        Route::get('/pengeluaran', [KeuanganController::class, 'pengeluaran'])->name('keuangan.pengeluaran');
        Route::get('/laporan', [KeuanganController::class, 'laporan'])->name('keuangan.laporan');
        Route::get('/akun', [KeuanganController::class, 'akun'])->name('keuangan.akun');
    });

    // Routes untuk Kunjungan
    Route::prefix('kunjungan')->group(function () {
        Route::get('/dashboard', [KunjunganController::class, 'dashboard'])->name('kunjungan.dashboard');
        Route::get('/rawat-jalan', [KunjunganController::class, 'rawatJalan'])->name('kunjungan.rawatjalan');
        Route::get('/rawat-inap', [KunjunganController::class, 'rawatInap'])->name('kunjungan.rawatinap');
        Route::get('/igd', [KunjunganController::class, 'igd'])->name('kunjungan.igd');
        Route::get('/operasi', [KunjunganController::class, 'operasi'])->name('kunjungan.operasi');
        
        // Routes untuk Laporan
        Route::prefix('laporan')->group(function () {
            Route::get('/harian', [KunjunganController::class, 'laporanHarian'])->name('kunjungan.laporan.harian');
            Route::get('/bulanan', [KunjunganController::class, 'laporanBulanan'])->name('kunjungan.laporan.bulanan');
            Route::get('/tahunan', [KunjunganController::class, 'laporanTahunan'])->name('kunjungan.laporan.tahunan');
        });
    });

    // Tambahkan di dalam group middleware 'web'
    Route::get('/profile', function() {
        return view('profile.index');
    })->name('profile');

    Route::get('/settings', function() {
        return view('settings.index');
    })->name('settings');
});
