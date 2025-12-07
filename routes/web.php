<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CelebrateController;

// Password-only login
Route::get('/', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');

// Protected surprise
Route::get('/celebrate', [CelebrateController::class, 'show'])->name('celebrate');
Route::post('/wish', [CelebrateController::class, 'saveWish'])->name('wish.save');

// Bye / thanks page
Route::get('/bye', [CelebrateController::class, 'bye'])->name('bye');

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

