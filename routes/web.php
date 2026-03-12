<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('login');
});

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

route::middleware('auth:siswa')->group(function(){
    route::get('/dashboard-siswa', [AuthController::class, 'dashboardSiswa'])->name('siswa.dashboard_siswa');
});

route::middleware('auth:admin')->group(function(){
    route::get('/dashboard-admin', [AuthController::class, 'dashboardAdmin'])->name('admin.dashboard_admin');
});