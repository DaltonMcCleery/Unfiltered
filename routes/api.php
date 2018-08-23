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
    Route::resource('game', 'GameController')
        ->only(['postQuestion', 'postAnswer', 'decideWinner']);

    Route::get('find/games', 'GameController@find');
});