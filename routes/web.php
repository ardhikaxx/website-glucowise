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
Route::get('/data_kesehatan', [DataKesehatanController::class, 'index']);
Route::get('/riwayat_kesehatan', [RiwayatKesehatanController::class, 'index']);
Route::get('/edukasi', [EdukasiController::class, 'index']);
// Route::get('/', function () {
//     return view('welcome');
// });
