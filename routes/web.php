<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\TestsAlgorithms\WordsCheckController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/parameters', [IndexController::class, 'parameters'])
    ->name('index.parameters');

Route::post('/test', [WordsCheckController::class, 'manageWords']);

Route::get('/profile', [IndexController::class, 'profile'])
    ->name('profile');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// проверка для перехода на защищенные роуты
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});


//require __DIR__ . '/auth.php';

