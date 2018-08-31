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

Route::redirect('/home', '/', 301);
Route::get('/', 'HomeController@index')->name('home');

Route::get('/how-to-play', function () {
    return view('how_to');
});

// --- Authenticated Customer --- //
Route::middleware('ninja')->group(function () {

    // ---> GAME
    Route::prefix('play')->group(function () {
        Route::get('/', 'GameController@index')->name('find.game');
        Route::post('/join', 'GameController@joinPrivateGame')->name('join.game');
        Route::get('/lobby/{session_id}', 'GameController@lobby')->name('game.lobby');
        Route::get('/game/{session_id}', 'GameController@play')->name('play.game');
    });
    Route::post('create/game', 'GameController@createGame')->name('create.game');

    // ---> PROFILE
    Route::prefix('my-profile')->group(function () {
        Route::get('/', 'NinjaController@index')->name('ninja.profile');
        Route::get('/update', 'NinjaController@updateProfile')->name('ninja.update.profile');
    });
});

// --- Admin --- //
Route::middleware('admin')->group(function () {

    // ---> Dashboard
    Route::prefix('dashboard')->group(function () {
        Route::get('/', 'AdminController@index')->name('find.game');
    });
});

Auth::routes();
Route::post('/login', 'Auth\LoginController@login');
Route::get('/logout', 'Auth\LoginController@logout');