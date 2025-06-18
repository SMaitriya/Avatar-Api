<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BibliothequeController;





Route::get('/', [HomeController::class, 'index'])->name('home');



Route::middleware(['auth'])->group(function () {
    Route::get('/bibliotheque', [BibliothequeController::class, 'index'])->name('bibliotheque');
}); /// A modifier car auth n'existe plus depuis breeze

