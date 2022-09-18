<?php

use App\Http\Controllers\Post\ShareController;
use App\Http\Controllers\Post\TestController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/share', ShareController::class)->name('share');

Route::get('/test', TestController::class)->name('test');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

