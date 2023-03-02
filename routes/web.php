<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\TestsAlgorithms\WordsCheckController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', [IndexController::class, 'home'])
    ->name('home');

Route::post('/single_test', [WordsCheckController::class, 'manageWords']);

Route::get('/single_test', [IndexController::class, 'testProcess']);

// Route::post('/dashboard', [IndexController::class, 'create'])
//     ->middleware(['auth', 'verified']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::post('/dashboard', [DashboardController::class, 'create']);

    Route::get('/dashboard/{dashboard}', [DashboardController::class, 'details'])->name('dashboard.details');
});
