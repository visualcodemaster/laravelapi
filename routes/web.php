<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
})->name('landing');

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home.index');
    Route::get('test', 'V1\TestController@index')->name('test.index');
    Route::group(['middleware' => ['permissions']], function () {
        Route::get('admin/dashboard', 'V1\DashboardController@adminDashboard')->name('admin.dashboard');
        Route::get('user/dashboard', 'V1\DashboardController@userDashboard')->name('users.dashboard');

        //User Section
        Route::group(['prefix' => 'users'], function () {
            Route::get('{user}/role/attach', 'V1\Roles\RoleController@attachRoleToUserCreate')->name('users.attach.role.index');
            Route::post('{user}/role/attach', 'V1\Roles\RoleController@attachRoleToUserStore')->name('users.attach.role.store');
        });
        Route::resource('users','Users\UserController');

        // Role section
        Route::group(['prefix' => 'roles'], function () {
            Route::get('{role}/users', 'V1\Roles\RoleController@rolesAttachedUsers')->name('roles.attached.users');
            Route::get('{role}/permissions', 'V1\Roles\RolePermissionsController@rolePermissions')->name('roles.permissions');
            Route::post('{role}/permissions', 'V1\Roles\RolePermissionsController@rolePermissionsStore')->name('roles.permissions.store');
        });
        Route::resource('roles', 'V1\Roles\RoleController');
    });
});

