<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\TestsAlgorithms\WordsCheckController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/signin', [IndexController::class, 'signin'])->name('index.signin');

Route::get('/parameters', [IndexController::class, 'parameters'])->name('index.parameters');

Route::post('/parameters', [WordsCheckController::class, 'manageWords']);

Route::post('/test', [WordsCheckController::class, 'manageWords'])->name('test.process');

Route::get('/test', [IndexController::class, 'testProcess'])->name('test.process');


require __DIR__.'/auth.php';



Route::get('/home', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
