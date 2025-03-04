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
Route::get('/data_admin', [DataAdminController::class, 'index'])->name('admin.index');
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

Route::prefix('riwayat_kesehatan')->group(function () {

    // Menampilkan halaman utama Riwayat Kesehatan
    Route::get('/', [RiwayatKesehatanController::class, 'index'])->name('riwayatKesehatan.index');

    // Menampilkan form untuk menambah data Riwayat Kesehatan
    Route::get('/create', [RiwayatKesehatanController::class, 'create'])->name('riwayatKesehatan.create');

    // Menyimpan data Riwayat Kesehatan baru
    Route::post('/', [RiwayatKesehatanController::class, 'store'])->name('riwayatKesehatan.store');

    // Menampilkan halaman edit untuk Riwayat Kesehatan tertentu
    Route::get('/{nomor_kk}/edit', [RiwayatKesehatanController::class, 'edit'])->name('riwayatKesehatan.edit'); 

    // Mengupdate data Riwayat Kesehatan tertentu
    Route::put('/{nomor_kk}', [RiwayatKesehatanController::class, 'update'])->name('riwayatKesehatan.update');

    // Menampilkan detail data Riwayat Kesehatan tertentu
    Route::get('/{nomor_kk}', [RiwayatKesehatanController::class, 'show'])->name('riwayatKesehatan.show');

    // Menghapus data Riwayat Kesehatan tertentu
    Route::delete('/{nomor_kk}', [RiwayatKesehatanController::class, 'destroy'])->name('riwayatKesehatan.destroy');

    // Melakukan pencarian Riwayat Kesehatan
    Route::get('/search', [RiwayatKesehatanController::class, 'search'])->name('riwayatKesehatan.search');
});


// Route::get('/', function () {
//     return view('welcome');
// });
