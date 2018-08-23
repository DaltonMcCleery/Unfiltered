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

    Route::prefix('game')->group(function () {
        Route::post('start', 'GameController@startGame');
        Route::post('post-question', 'GameController@postQuestion');
        Route::post('post-answer', 'GameController@postAnswer');
        Route::post('round-winner', 'GameController@decideRoundWinner');
        Route::post('match-winner', 'GameController@decideMatchWinner');
    });

    Route::get('find/games', 'GameController@find');
});