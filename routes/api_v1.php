<?php
Route::post( 'login', 'Auth\AuthController@login' )->name( 'auth.login' );

Route::get('test', 'TestController@index')->name('test.index');
Route::group(['middleware' => ['auth.api:api']], function() {

    Route::post('logout', 'Auth\AuthController@logout')->name('auth.logout');

});
