<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DataPenggunaController;
use App\Http\Controllers\Api\GlucoCareController;
use App\Http\Controllers\Api\GlucoCheckController;
use App\Http\Controllers\Api\EdukasiController;
use App\Http\Controllers\Api\ScreeningController;
use App\Http\Controllers\Api\ChatController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// ==============================
// ROUTE AUTHENTIKASI PENGGUNA
// ==============================
Route::prefix('auth')->group(function () {
    Route::post('/register', [DataPenggunaController::class, 'register']);
    Route::post('/login', [DataPenggunaController::class, 'login']);
    Route::post('/edit-profile', [DataPenggunaController::class, 'editProfile']);
    Route::post('/check-email', [DataPenggunaController::class, 'checkEmail']);
    Route::post('/update-password', [DataPenggunaController::class, 'updatePassword']);
});

// ==============================
// ROUTE PROFIL PENGGUNA
// ==============================
Route::post('/profile', [DataPenggunaController::class, 'getProfile']);

// ==============================
// ROUTE GLUCO CARE (MANAJEMEN PERAWATAN)
// ==============================
Route::prefix('gluco-care')->group(function () {
    Route::post('/add', [GlucoCareController::class, 'addCare']);
    Route::post('/edit/{id_care}', [GlucoCareController::class, 'editCare']);
    Route::get('/active/{nik}', [GlucoCareController::class, 'getActiveCare']);
    Route::get('/history/{nik}', [GlucoCareController::class, 'getHistoryCare']);
    Route::delete('/delete/{id_care}', [GlucoCareController::class, 'deleteCare']);
});

// ==============================
// ROUTE GLUCO CHECK (PEMERIKSAAN GLUKOSA)
// ==============================
Route::prefix('gluco-check')->group(function () {
    Route::post('/add', [GlucoCheckController::class, 'addCheck']);
    Route::get('/history/{nik}', [GlucoCheckController::class, 'getHistory']);
    Route::get('/status/{id_data}', [GlucoCheckController::class, 'getStatus']);
});

// ==============================
// ROUTE SCREENING (PENAPISAN KESEHATAN)
// ==============================
Route::prefix('screening')->group(function () {
    Route::get('/questions', [ScreeningController::class, 'getQuestionsWithAnswers']);
    Route::post('/results', [ScreeningController::class, 'storeScreeningResults']);
    Route::get('/results/{id}', [ScreeningController::class, 'getScreeningResult']);
    Route::get('/history/{nik}', [ScreeningController::class, 'getScreeningHistory']);
});

// ==============================
// ROUTE CHAT KONSULTASI
// ==============================
Route::prefix('chat')->group(function () {
    Route::get('/dokters', [ChatController::class, 'getDokters']);
    Route::post('/conversation', [ChatController::class, 'getOrCreateConversation']);
    Route::post('/send-message', [ChatController::class, 'sendMessage']);
    Route::get('/messages/{id_conversation}', [ChatController::class, 'getMessages']);
    Route::get('/conversations/{nik}', [ChatController::class, 'getUserConversations']);
    Route::post('/mark-read', [ChatController::class, 'markAsRead']);
});

// ==============================
// ROUTE EDUKASI (MATERI EDUKASI)
// ==============================
Route::get('/edukasi', [EdukasiController::class, 'index']);