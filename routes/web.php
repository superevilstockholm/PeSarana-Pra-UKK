<?php

use Illuminate\Support\Facades\Route;

// Auth Controller
use App\Http\Controllers\AuthController;

// Dashboard Controller
use App\Http\Controllers\DashboardController;

// Master Data Controllers
use App\Http\Controllers\MasterData\UserController;
use App\Http\Controllers\MasterData\StudentController;
use App\Http\Controllers\MasterData\CategoryController;
use App\Http\Controllers\MasterData\ClassroomController;
use App\Http\Controllers\MasterData\AspirationController;
use App\Http\Controllers\MasterData\AspirationFeedbackController;

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
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
            Route::get('/', [DashboardController::class, 'admin'])->name('index');
            Route::prefix('master-data')->name('master-data.')->group(function () {
                Route::resource('classrooms', ClassroomController::class)->parameters([
                    'classrooms' => 'classroom'
                ]);
                Route::resource('students', StudentController::class)->parameters([
                    'students' => 'student'
                ]);
                Route::resource('users', UserController::class)->parameters([
                    'users' => 'user'
                ]);
                Route::resource('categories', CategoryController::class)->parameters([
                    'categories' => 'category'
                ]);
                Route::resource('aspirations', AspirationController::class)->parameters([
                    'aspirations' => 'aspiration',
                ])->only(['index', 'show', 'destroy']);
                Route::resource('aspiration-feedbacks', AspirationFeedbackController::class)->parameters([
                    'aspiration-feedbacks' => 'aspirationFeedback'
                ])->only(['store', 'update', 'destroy']);
            });
        });
        Route::middleware(['role:student'])->prefix('student')->name('student.')->group(function () {
            Route::get('/', [DashboardController::class, 'student'])->name('index');
            Route::resource('aspirations', AspirationController::class)->parameters([
                'aspirations' => 'aspiration',
            ]);
        });
    });
});
