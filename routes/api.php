<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ApiKeyController;
use App\Http\Controllers\SvgElementController;
use App\Http\Controllers\AvatarCompletController;
use App\Http\Controllers\BibliothequeController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\ApiKeyMiddleware;
use App\Http\Controllers\AvatarApiController;

// ROUTE POUR LA RECUPERATION DES SVG 
Route::get('/svg-elements', [SvgElementController::class, 'index']);

// Route API protégée par clé API pour obtenir tous les avatars (version minimale)
Route::middleware([ApiKeyMiddleware::class])->get('/public-avatars', [AvatarApiController::class, 'allAvatarsMinimal']);

// Route publique pour obtenir tous les avatars complets 
Route::get('/avatars/all', [BibliothequeController::class, 'allAvatars']);

// Retourne l'utilisateur connecté 
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Routes protégées par Sanctum pour gérer les avatars de l'utilisateur connecté
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/avatar_complet', [AvatarCompletController::class, 'store']); 
    Route::get('/bibliotheque', [BibliothequeController::class, 'recuperer']); 
    Route::delete('/avatars/{id}', [BibliothequeController::class, 'delete']); 
});

// Authentification (inscription, connexion, déconnexion)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Gestion des clés API (routes réservées aux admins)
Route::middleware(\App\Http\Middleware\AdminMiddleware::class)->group(function () {
    Route::get('/admin/api-keys', [ApiKeyController::class, 'index']);
    Route::post('/admin/api-keys/generate', [ApiKeyController::class, 'generate']);
    Route::patch('/admin/api-keys/{id}/toggle', [ApiKeyController::class, 'toggleStatus']);
    Route::delete('/admin/api-keys/{id}', [ApiKeyController::class, 'delete']);
});