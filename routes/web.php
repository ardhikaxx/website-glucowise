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
Route::prefix('data_pengguna')->group(function () {
    Route::get('/', [DataPenggunaController::class, 'index'])->name('dataPengguna.index');
    Route::get('/show/{id}', [DataPenggunaController::class, 'show'])->name('dataPengguna.show');
    
    // Route untuk pencarian data pengguna
    Route::get('/search', [DataPenggunaController::class, 'index'])->name('dataPengguna.search');
});

use App\Http\Controllers\AdminController;


Route::get('admin', [AdminController::class, 'index'])->name('admin.index');
Route::get('admin/create', [AdminController::class, 'create'])->name('admin.create');
Route::post('admin/store', [AdminController::class, 'store'])->name('admin.store');
Route::get('admin/{id}/edit', [AdminController::class, 'edit'])->name('admin.edit');
Route::put('admin/{id_admin}/update', [AdminController::class, 'update'])->name('admin.update');
Route::delete('admin/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');




    Route::prefix('data-kesehatan')->name('dataKesehatan.')->group(function () {
        Route::get('/', [DataKesehatanController::class, 'index'])->name('index'); // Menampilkan daftar data kesehatan
        Route::get('/search', [DataKesehatanController::class, 'search'])->name('search'); // Pencarian data kesehatan
        Route::get('/edit/{nik}', [DataKesehatanController::class, 'edit'])->name('edit'); // Menampilkan halaman edit untuk data kesehatan berdasarkan NIK
        Route::put('/update/{nik}', [DataKesehatanController::class, 'update'])->name('update'); // Mengupdate data kesehatan berdasarkan NIK
        Route::get('/detail/{nik}', [DataKesehatanController::class, 'show'])->name('show'); // Menampilkan detail data kesehatan berdasarkan NIK
    });
    

    Route::prefix('edukasi')->name('edukasi.')->group(function () {
        Route::get('/', [EdukasiController::class, 'index'])->name('index');
        Route::get('/create', [EdukasiController::class, 'createOrEdit'])->name('create');
        Route::post('/', [EdukasiController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [EdukasiController::class, 'createOrEdit'])->name('edit');
        Route::put('/{id}', [EdukasiController::class, 'update'])->name('update');
        Route::delete('/{id}', [EdukasiController::class, 'destroy'])->name('destroy');
    });
    

Route::prefix('riwayat_kesehatan')->group(function () {
    Route::get('/', [RiwayatKesehatanController::class, 'index'])->name('riwayatKesehatan.index');
    Route::get('/create', [RiwayatKesehatanController::class, 'create'])->name('riwayatKesehatan.create');
    Route::post('/', [RiwayatKesehatanController::class, 'store'])->name('riwayatKesehatan.store');
    Route::get('/{id_riwayat}/edit', [RiwayatKesehatanController::class, 'edit'])->name('riwayatKesehatan.edit');
Route::put('/{id_riwayat}', [RiwayatKesehatanController::class, 'update'])->name('riwayatKesehatan.update');

    Route::get('/{nik}', [RiwayatKesehatanController::class, 'show'])->name('riwayatKesehatan.show');
});

Route::get('/riwayat_kesehatan/search', [RiwayatKesehatanController::class, 'search'])->name('riwayatKesehatan.search');



// Route::get('/', function () {
//     return view('welcome');
// });
