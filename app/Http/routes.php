<?php
//use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



// 認證路由...
get('auth/login', 'AuthController@getLogin')->name('login');
post('auth/login', 'AuthController@postLogin');
get('auth/logout', 'AuthController@getLogout')->name('logout');

// 註冊路由...
get('auth/register', 'AuthController@getRegister')->name('register');
post('auth/register', 'AuthController@postRegister');
get('auth/user-confirm', 'AuthController@getUserConfirm')->name('userConfirm');

Route::group(['middleware' => 'auth'], function () {
    get('/', 'HomeController@index');
    get('post', 'HomeController@index')->name('post');
    get('post/create', 'HomeController@create');
    post('post', 'HomeController@store');
    get('post/{id}', 'HomeController@show');
    get('post/{id}/edit', 'HomeController@edit');
    put('post/{id}', 'HomeController@update');
    delete('post/{id}', 'HomeController@destroy');

    get('password/reset_password', 'PasswordController@getResetPassword')->name('resetPassword');
    post('password/reset_password', 'PasswordController@postResetPassword');
});

get('password/forgot_password', 'PasswordController@getForgotPassword')->name('forgotPassword');
post('password/forgot_password', 'PasswordController@postForgotPassword');

