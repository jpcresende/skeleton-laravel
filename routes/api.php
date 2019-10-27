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
    'middleware' => 'api',
    'namespace' => '\App\Core\Http\Controllers'
], function () {
    // public routes
    Route::post('/login', 'AutenticacaoController@login')->name('autenticacao.login');

    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

    // private routes
    Route::middleware('auth')->group(function () {
        Route::get('/logout', 'AutenticacaoController@logout')->name('autenticacao.logout');

        Route::post('/user', 'UserController@store')->name('user.store');
        Route::get('/user/role', 'ModelHasRoleController@index')->name('modelrole.index');
        Route::post('/user/role', 'ModelHasRoleController@store')->name('modelrole.store');
        Route::delete('/user/role', 'ModelHasRoleController@destroy')->name('modelrole.destroy');
        Route::get('/role', 'RoleController@index')->name('role.index');
    });
});
