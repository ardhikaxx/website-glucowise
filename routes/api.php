<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DataPenggunaController;
use App\Http\Controllers\Api\GlucoCareController;
use App\Http\Controllers\Api\GlucoCheckController;
use App\Http\Controllers\Api\EdukasiController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/auth/register', [DataPenggunaController::class, 'register']);
Route::post('/auth/login', [DataPenggunaController::class, 'login']);
Route::post('/auth/edit-profile', [DataPenggunaController::class, 'editProfile']);
Route::post('/auth/check-email', [DataPenggunaController::class, 'checkEmail']);
Route::post('/auth/update-password', [DataPenggunaController::class, 'updatePassword']);
Route::post('/profile', [DataPenggunaController::class, 'getProfile']);
Route::prefix('gluco-care')->group(function () {
    Route::post('/add', [GlucoCareController::class, 'addCare']);
    Route::post('/edit/{id_care}', [GlucoCareController::class, 'editCare']);
    Route::get('/active/{nik}', [GlucoCareController::class, 'getActiveCare']);
    Route::get('/history/{nik}', [GlucoCareController::class, 'getHistoryCare']);
    Route::delete('/delete/{id_care}', [GlucoCareController::class, 'deleteCare']);
});
Route::prefix('gluco-check')->group(function () {
    Route::post('/add', [GlucoCheckController::class, 'addCheck']);
    Route::get('/history/{nik}', [GlucoCheckController::class, 'getHistory']);
    Route::get('/status/{id_data}', [GlucoCheckController::class, 'getStatus']);
});
Route::prefix('screening')->group(function () {
    Route::get('/questions', [\App\Http\Controllers\Api\ScreeningController::class, 'getQuestionsWithAnswers']);
    Route::post('/results', [\App\Http\Controllers\Api\ScreeningController::class, 'storeScreeningResults']);
    Route::get('/results/{id}', [\App\Http\Controllers\Api\ScreeningController::class, 'getScreeningResult']);
    Route::get('/history/{nik}', [\App\Http\Controllers\Api\ScreeningController::class, 'getScreeningHistory']);
});
Route::get('/edukasi', [EdukasiController::class, 'index']);