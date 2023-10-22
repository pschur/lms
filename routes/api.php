<?php

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

Route::middleware('guest:sanctum')->group(function(){
    Route::post('/login', [App\Http\Controllers\ApiAuthController::class, 'login']);
    Route::post('/register', [App\Http\Controllers\ApiAuthController::class, 'register']);
});

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/user', [App\Http\Controllers\ApiAuthController::class, 'user']);
    Route::post('/refresh', [App\Http\Controllers\ApiAuthController::class, 'refresh']);
    Route::post('/logout', [App\Http\Controllers\ApiAuthController::class, 'logout']);
});
