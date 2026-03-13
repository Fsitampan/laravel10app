<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KategoriController;

Route::get('/', fn() => view('login'));
Route::get('/login',  [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout',[AuthController::class, 'logout'])->name('logout');

// ── SISWA ────────────────────────────────────────────────
Route::middleware('auth:siswa')->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard',        [SiswaController::class, 'dashboard'])->name('dashboard_siswa');
    Route::get('/aspirasi/create',  [SiswaController::class, 'create'])->name('create');
    Route::post('/aspirasi',        [SiswaController::class, 'store'])->name('store');
    Route::get('/status',           [SiswaController::class, 'status'])->name('status');
    Route::get('/histori',          [SiswaController::class, 'histori'])->name('histori');
});

// ── ADMIN ─────────────────────────────────────────────────
Route::middleware('auth:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard',            [AdminController::class, 'dashboard'])->name('dashboard_admin');
    Route::get('/aspirasi',             [AdminController::class, 'index'])->name('aspirasi.index');
    Route::get('/aspirasi/{id}',        [AdminController::class, 'show'])->name('aspirasi.show');
    Route::put('/aspirasi/{id}',        [AdminController::class, 'update'])->name('aspirasi.update');
    Route::resource('/kategori',        KategoriController::class)->only(['index','store','destroy'])->names([
        'index'   => 'kategori.index',
        'store'   => 'kategori.store',
        'destroy' => 'kategori.destroy',
    ]);
});