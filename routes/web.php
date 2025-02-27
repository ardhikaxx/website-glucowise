<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DataPenggunaController;
use App\Http\Controllers\DataAdminController;
use App\Http\Controllers\DataKesehatanController;
use App\Http\Controllers\EdukasiController;
use App\Http\Controllers\RiwayatKesehatanController;


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

Route::get('/', [WelcomeController::class, 'index']);
Route::get('/login', [AuthController::class, 'showLoginForm']);
Route::get('/register', [AuthController::class, 'showRegistForm']);
Route::get('/data_pengguna', [DataPenggunaController::class, 'index']);
Route::get('/data_admin', [DataAdminController::class, 'index']);
Route::get('/data-kesehatan', [DataKesehatanController::class, 'index'])->name('dataKesehatan.index');
Route::get('/data-kesehatan/search', [DataKesehatanController::class, 'search'])->name('dataKesehatan.search');
Route::get('/data-kesehatan/edit/{nomor_kk}', [DataKesehatanController::class, 'edit'])->name('dataKesehatan.edit');
Route::post('/data-kesehatan/update/{nomor_kk}', [DataKesehatanController::class, 'update'])->name('dataKesehatan.update');
Route::get('/data-kesehatan/detail/{nomor_kk}', [DataKesehatanController::class, 'show'])->name('dataKesehatan.show');

Route::get('/edukasi', [EdukasiController::class, 'index'])->name('edukasi.index');
Route::get('/edukasi/create', [EdukasiController::class, 'create'])->name('edukasi.create');
Route::post('/edukasi', [EdukasiController::class, 'store'])->name('edukasi.store');
Route::get('/edukasi/{id}', [EdukasiController::class, 'show'])->name('edukasi.show');
Route::get('/edukasi/{id}/edit', [EdukasiController::class, 'edit'])->name('edukasi.edit');
Route::put('/edukasi/{id}', [EdukasiController::class, 'update'])->name('edukasi.update');
Route::delete('/edukasi/{id}', [EdukasiController::class, 'destroy'])->name('edukasi.destroy');

Route::get('/riwayat_kesehatan', [RiwayatKesehatanController::class, 'index']);

// Route::get('/', function () {
//     return view('welcome');
// });
