<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\AuthController;

// Middleware web já é aplicado por padrão no web.php, então você não precisa declarar ['web'] aqui.
Route::get('/auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('google.redirect');
Route::post('/auth/register/google', [AuthController::class, 'registerFromGoogle']);