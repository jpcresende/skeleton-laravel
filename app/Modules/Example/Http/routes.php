<?php

use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['json.response']], function () {
    // private routes
    Route::middleware('auth:api')->group(function () {
        Route::get('/', 'IndexController@index');
    });
});
