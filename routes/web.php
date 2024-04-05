<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\FriendsController;
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

    // friends
    Route::get('/friends', [FriendsController::class, 'showPage'])->name('show.friends');
    Route::get('/api/get-friends', [FriendsController::class, 'index']);
    Route::get('/api/search-people/{name}', [FriendsController::class, 'searchPeople']);
    Route::get('/api/add-friend/{id}', [FriendsController::class, 'addFriend']);
    Route::get('/api/check-invites', [FriendsController::class, 'getInvitesForMyself']);
    Route::get('/api/accept-friendship-invitation/{id}', [FriendsController::class, 'acceptFriendshipInvite']);
    Route::get('/api/accept-all-invitations', [FriendsController::class, 'acceptAllInvitations']);
    Route::delete('/api/delete-friend/{id}', [FriendsController::class, 'delete']);

    // messages
    Route::post('/api/get-messages', [ChatController::class, 'startChat']);
    Route::post('/api/send-message', [ChatController::class, 'sendMessage']);

});
