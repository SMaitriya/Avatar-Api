<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ApiKeyController;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Authentification
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// gestion des clés API
Route::middleware(\App\Http\Middleware\AdminMiddleware::class)->group(function () {
    Route::get('/admin/api-keys', [ApiKeyController::class, 'index']);
    Route::post('/admin/api-keys/generate', [ApiKeyController::class, 'generate']);
    Route::patch('/admin/api-keys/{id}/toggle', [ApiKeyController::class, 'toggleStatus']);
    Route::delete('/admin/api-keys/{id}', [ApiKeyController::class, 'delete']);
});
