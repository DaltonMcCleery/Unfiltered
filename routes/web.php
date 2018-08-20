<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/how-to-play', function () {
    return view('how_to');
});

// --- Authenticated Customer --- //
Route::middleware('ninja')->group(function () {

    // ---> GAME
    Route::prefix('play')->group(function () {
        Route::get('/', 'GameController@index')->name('find.game');
        Route::get('/session/{session_id}', 'GameController@play')->name('play.game');
    });

    // ---> PROFILE
    Route::prefix('my-profile')->group(function () {
        Route::get('/', 'NinjaController@index')->name('ninja.profile');
        Route::get('/update', 'NinjaController@updateProfile')->name('ninja.update.profile');
    });
});