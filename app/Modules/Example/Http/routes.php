<?php

use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['api']], function () {
    // private routes
    Route::middleware('auth')->group(function () {
        Route::get('/', 'IndexController@index');
    });
});
