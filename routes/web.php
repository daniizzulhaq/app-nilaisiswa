<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

// Admin
use App\Http\Controllers\Admin\{
    DashboardController,
    SiswaController,
    GuruController,
    KelasController,
    MataPelajaranController,
    KkmController,
    UserController
};

// Guru
use App\Http\Controllers\Guru\NilaiController;
use App\Http\Controllers\Guru\DashboardController as GuruDashboardController;

// Siswa
use App\Http\Controllers\Siswa\NilaiSiswaController;

// Laporan & Profile
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileController;


// ─── Auth ────────────────────────────────────────────────────
Route::get('/',        [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login',  [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// ─── Admin ───────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('siswa', SiswaController::class);
    Route::resource('guru', GuruController::class);
    Route::resource('kelas', KelasController::class);
    Route::resource('mata-pelajaran', MataPelajaranController::class)->names('mapel');
    Route::resource('kkm', KkmController::class);

    // ✅ Tambahan user management
    Route::resource('user', UserController::class)->except(['show']);
});


// ─── Guru ────────────────────────────────────────────────────
Route::prefix('guru')->name('guru.')->middleware(['auth', 'role:guru'])->group(function () {

    // ✅ Dashboard khusus guru
    Route::get('/dashboard', [GuruDashboardController::class, 'index'])->name('dashboard');

    Route::resource('nilai', NilaiController::class);

    // AJAX siswa by kelas
    Route::get('/siswa-by-kelas', function () {
        return response()->json(
            \App\Models\Siswa::where('kelas_id', request('kelas_id'))
                ->get(['id','nama','nis'])
        );
    })->name('siswa.by.kelas');
});


Route::prefix('siswa')->name('siswa.')->middleware(['auth', 'role:siswa'])->group(function () {

    Route::get('/dashboard', [NilaiSiswaController::class, 'index'])->name('dashboard');

    Route::get('/nilai/{semester}/{tahun_ajaran}', [NilaiSiswaController::class, 'show'])
        ->name('nilai.detail');

    // ✅ Tambahkan ini
    Route::get('/raport', [NilaiSiswaController::class, 'raport'])->name('raport');
    Route::get('/raport/export-pdf', [NilaiSiswaController::class, 'exportPdf'])->name('raport.export.pdf');
});

// ─── Laporan ─────────────────────────────────────────────────
Route::prefix('laporan')->name('laporan.')->middleware(['auth', 'role:admin,guru'])->group(function () {

    Route::get('/raport/{siswa}', [LaporanController::class, 'raport'])->name('raport');
    Route::get('/rekap-kelas', [LaporanController::class, 'rekapKelas'])->name('rekap');
    Route::get('/export-pdf/{siswa}', [LaporanController::class, 'exportPdf'])->name('export.pdf');
    Route::get('/export-excel', [LaporanController::class, 'exportExcel'])->name('export.excel');
    Route::get('/rekap/export', [LaporanController::class, 'exportExcel'])->name('rekap.export');
});


// ─── Profile (Semua Role) ────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});