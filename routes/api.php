<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ApiKeyController;
use App\Http\Controllers\SvgElementController;
use App\Http\Controllers\AvatarCompletController;
use App\Http\Controllers\BibliothequeController;


// ROUTE POUR LA RCUPERATION DES SVG ET MISE EN CACHE
Route::get('/svg-elements', [SvgElementController::class, 'index']);


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Route pour sauvegarder et récupérer les avatars

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/avatar_complet', [AvatarCompletController::class, 'store']);
    Route::get('/bibliotheque', [BibliothequeController::class, 'recuperer']);
});

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
