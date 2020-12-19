<?php
Route::post( 'login', 'Auth\AuthController@login' )->name( 'auth.login' );

Route::group(['middleware' => ['auth.api:api']], function() {
    Route::get('test', 'TestController@index')->name('test.index');
    Route::post('logout', 'Auth\AuthController@logout')->name('auth.logout');
});
