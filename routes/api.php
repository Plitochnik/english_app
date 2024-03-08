<?php

use App\Http\Controllers\FriendsController;
use App\Http\Controllers\IndexController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// group sanctrum
Route::middleware(['auth:sanctum'])->group(function () {
    // Friends
//    Route::get('/add-friend/{id}', [FriendsController::class, 'addFriend']);
});


