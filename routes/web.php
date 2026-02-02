<?php

use Illuminate\Support\Facades\Route;

// Auth Controller
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

// Optional Protected
Route::middleware(['optional.auth.sanctum.cookie'])->group(function () {
    Route::match(['get', 'post'], 'login', [AuthController::class, 'login'])->name('login');
});

// Protected
Route::middleware(['auth.sanctum.cookie'])->group(function () {
    Route::middleware(['role:admin'])->group(function () {

    });
    Route::middleware(['role:student'])->group(function () {

    });
});
