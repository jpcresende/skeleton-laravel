<?php

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

Route::group([
    'middleware' => ['json.response'],
    'namespace' => '\App\Core\Http\Controllers'
], function () {
    // public routes
    Route::post('/autenticacao', 'AutenticacaoController@autenticar')->name('autenticacao.autenticar');

    // private routes
    Route::middleware('auth:api')->group(function () {
        Route::post('/usuario', 'UserController@store')->name('usuario.cadastrar');
        Route::get('/sair', 'AutenticacaoController@sair')->name('autenticacao.sair');
    });
});
