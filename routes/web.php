<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BibliothequeController;
use App\Http\Controllers\AuthController;

// Accueil
Route::get('/', [HomeController::class, 'index'])->name('home');

// Page bibliothèque
Route::get('/bibliotheque', [BibliothequeController::class, 'index'])->middleware('auth')->name('bibliotheque');

// Page login
Route::get('/login', function () {
    return view('login');
})->name('login');

// Page register
Route::get('/register', function () {
    return view('register');
})->name('register');

// Page d'admin pour gestion des clés (vue)
Route::get('/admin/api-keys', function () {
    return view('api-keys');
})->name('api-keys.index');


Route::get('/bibliotheque', [BibliothequeController::class, 'index']);
