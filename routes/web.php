<?php

use App\Http\Controllers\Post\ShareController;
use App\Http\Controllers\Post\TestController;
use App\Http\Controllers\Scaning\ScaningController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/share', ShareController::class)->name('share');

Route::post('/test', TestController::class)->name('test');

Route::post('/scaning', ScaningController::class)->name('scaning');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
