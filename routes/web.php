<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Optional Protected
Route::middleware(['optional.auth.sanctum.cookie'])->group(function () {

});

// Protected
Route::middleware(['auth.sanctum.cookie'])->group(function () {
    Route::middleware(['role:admin'])->group(function () {

    });
    Route::middleware(['role:student'])->group(function () {

    });
});
