<?php

use App\Http\Controllers\Api\DataPenggunaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post('/auth/profile', [DataPenggunaController::class, 'getProfile']);