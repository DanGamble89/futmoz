<?php

Route::get('/', function () {
    return view('index');
});

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
*/
Route::group(['prefix' => 'api'], function () {
    Route::resource('authenticate', 'AuthenticateController', ['only' => ['index']]);
    Route::post('authenticate', 'AuthenticateController@authenticate');
});
