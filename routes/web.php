<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BibliothequeController;





Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/bibliotheque', [BibliothequeController::class, 'index'])->name('bibliotheque');

Route::get('/login', function () {
    return view('login');
})->name('login');
Route::get('/register', function () {
    return view('register');
})->name('register');
