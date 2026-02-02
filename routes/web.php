<?php

use Illuminate\Support\Facades\Route;

// Auth Controller
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('pages.index');
});

// Optional Protected
Route::middleware(['optional.auth.sanctum.cookie'])->group(function () {
    // Auth
    Route::match(['get', 'post'], 'login', [AuthController::class, 'login'])->name('login');
    Route::match(['get', 'post'], 'signup', [AuthController::class, 'signup'])->name('signup');
});

// Protected
Route::middleware(['auth.sanctum.cookie'])->group(function () {
    // Auth
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::middleware(['role:admin'])->group(function () {

    });
    Route::middleware(['role:student'])->group(function () {

    });
});
