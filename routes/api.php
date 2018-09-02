<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// --- Authenticated Customer --- //
Route::middleware(['api'])->group(function () {

    // ---> Game
    Route::prefix('game')->group(function () {
        Route::post('start', 'GameController@startGame');
        Route::post('post-question', 'GameController@postQuestion');
        Route::post('post-answer', 'GameController@postAnswer');
        Route::post('round-winner', 'GameController@decideRoundWinner');
        Route::post('match-winner', 'GameController@decideMatchWinner');
        Route::post('destroy-game', 'GameController@closeGame');
        Route::post('close-lobby', 'GameController@closeLobby');
        Route::post('kick-player', 'GameController@kickLobbyPlayer');
        Route::post('chat', 'GameController@chat');
    });
    Route::get('find/games', 'LobbyController@find');
    Route::post('update/lobby', 'LobbyController@updateLobbySessions');

    // ---> Profile
    Route::prefix('profile')->group(function () {
        Route::post('update', 'NinjaController@updateProfile');
    });

    // --> Reports
    Route::prefix('report')->group(function () {
        Route::post('/', 'HomeController@reportUser');
    });
});