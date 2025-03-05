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

Route::prefix('admin') // Grup route untuk admin
    ->name('admin.') // Menambahkan prefix untuk nama route
        ->group(function() {
        // Route untuk halaman index (tampilan daftar admin)
        Route::get('/', [DataAdminController::class, 'index'])->name('index');

        // Route untuk menampilkan form tambah admin
        Route::get('create', [DataAdminController::class, 'create'])->name('create');

        // Route untuk menyimpan data admin baru
        Route::post('/', [DataAdminController::class, 'store'])->name('store');

        // Route untuk menampilkan form edit admin
        Route::get('{id}/edit', [DataAdminController::class, 'edit'])->name('edit');

        // Route untuk mengupdate data admin
        Route::put('{id}', [DataAdminController::class, 'update'])->name('update');

        // Route untuk menghapus admin
        Route::delete('{id}', [DataAdminController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('data-kesehatan')->name('dataKesehatan.')->group(function () {
        Route::get('/', [DataKesehatanController::class, 'index'])->name('index'); // Menampilkan daftar data kesehatan
        Route::get('/search', [DataKesehatanController::class, 'search'])->name('search'); // Pencarian data kesehatan
        Route::get('/edit/{nik}', [DataKesehatanController::class, 'edit'])->name('edit'); // Menampilkan halaman edit untuk data kesehatan berdasarkan NIK
        Route::put('/update/{nik}', [DataKesehatanController::class, 'update'])->name('update'); // Mengupdate data kesehatan berdasarkan NIK
        Route::get('/detail/{nik}', [DataKesehatanController::class, 'show'])->name('show'); // Menampilkan detail data kesehatan berdasarkan NIK
    });
    

Route::get('/edukasi', [EdukasiController::class, 'index'])->name('edukasi.index');
Route::get('/edukasi/create', [EdukasiController::class, 'create'])->name('edukasi.create');
Route::post('/edukasi', [EdukasiController::class, 'store'])->name('edukasi.store');
Route::get('/edukasi/{id}', [EdukasiController::class, 'show'])->name('edukasi.show');
Route::get('/edukasi/{id}/edit', [EdukasiController::class, 'edit'])->name('edukasi.edit');
Route::put('/edukasi/{id}', [EdukasiController::class, 'update'])->name('edukasi.update');
Route::delete('/edukasi/{id}', [EdukasiController::class, 'destroy'])->name('edukasi.destroy');

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
