<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\PresensiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['guest:user'])->group(function () {
    Route::get('/panel', function () {
        return view('auth/loginAdmin');
    })->name('loginAdmin');
    Route::post('/prosesloginadmin', [AuthController::class, 'prosesLoginAdmin']);
});
Route::middleware(['guest:karyawan'])->group(function () {
    Route::get('/', function () {
        return view('auth/login');
    })->name('login');
    Route::post('/proseslogin', [AuthController::class, 'prosesLogin']);
});
Route::middleware(['auth:karyawan'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index']);
    Route::get('/proseslogout', [AuthController::class, 'prosesLogout']);
    Route::get('/presensi/create', [PresensiController::class, 'create']);
    Route::post('/presensi/store', [PresensiController::class, 'store']);
    Route::get('/editProfile', [PresensiController::class, 'editProfile']);
    Route::post('/presensi/{nik}/updateProfile', [PresensiController::class, 'updateProfile']);
    Route::get('/presensi/history', [PresensiController::class, 'history']);
    Route::get('/gethistori', [PresensiController::class, 'gethistori']);
});
Route::middleware(['auth:user'])->group(function () {
    Route::get('/panel/dashboardadmin', [DashboardController::class, 'dashboardAdmin']);
    Route::get('/proseslogoutadmin', [AuthController::class, 'prosesLogoutAdmin']);

    Route::get('/karyawan', [KaryawanController::class, 'index']);
});
