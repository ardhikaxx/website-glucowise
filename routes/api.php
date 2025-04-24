<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DataPenggunaController;
use App\Http\Controllers\Api\GlucoCareController;
use App\Http\Controllers\Api\GlucoCheckController;
use App\Http\Controllers\api\EdukasiController;

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
Route::post('/gluco-care/add', [GlucoCareController::class, 'addCare']);
Route::post('/gluco-care/edit/{id_care}', [GlucoCareController::class, 'editCare']);
Route::get('/gluco-care/active/{nik}', [GlucoCareController::class, 'getActiveCare']);
Route::get('/gluco-care/history/{nik}', [GlucoCareController::class, 'getHistoryCare']);
Route::delete('/gluco-care/delete/{id_care}', [GlucoCareController::class, 'deleteCare']);
Route::post('/gluco-check/add', [GlucoCheckController::class, 'addCheck']);
Route::get('/gluco-check/history/{nik}', [GlucoCheckController::class, 'getHistory']);
Route::get('/gluco-check/status/{id_data}', [GlucoCheckController::class, 'getStatus']);
Route::get('/edukasi', [EdukasiController::class, 'index']);
Route::prefix('screening')->group(function () {
    Route::get('/questions', [\App\Http\Controllers\Api\ScreeningController::class, 'getQuestionsWithAnswers']);
    Route::post('/results', [\App\Http\Controllers\Api\ScreeningController::class, 'storeScreeningResults']);
    Route::get('/results/{id}', [\App\Http\Controllers\Api\ScreeningController::class, 'getScreeningResult']);
    Route::get('/history/{nik}', [\App\Http\Controllers\Api\ScreeningController::class, 'getScreeningHistory']);
});