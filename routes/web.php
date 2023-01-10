<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\TestsAlgorithms\WordsCheckController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/about', function () {
    return Inertia::render('About');
})->name('about');

Route::get('/parameters', [IndexController::class, 'parameters'])
    ->name('parameters');


Route::post('/test', [WordsCheckController::class, 'manageWords']);
Route::get('/test', [IndexController::class, 'testProcess']);

Route::get('/profile', [IndexController::class, 'profile'])
    ->name('profile');

//Route::post('/dashboard', [IndexController::class, 'create'])
//    ->middleware(['auth', 'verified']);

// проверка для перехода на защищенные роуты
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/about', function () {
        return Inertia::render('About');
    })->name('about');

    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::post('/dashboard', [DashboardController::class, 'create']);
    Route::get('/dashboard/{dashboard}', [DashboardController::class, 'details'])->name('dashboard.details');

});

//require __DIR__ . '/auth.php';
