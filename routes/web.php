<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Protected
Route::middleware(['auth.sanctum.cookie'])->group(function () {

});
