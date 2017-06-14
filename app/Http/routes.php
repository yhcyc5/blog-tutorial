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

get('login/facebook', 'Auth\LoginController@redirectToProvider')->name('login-facebook');
get('login/facebook/callback', 'Auth\LoginController@handleProviderCallback');

// 註冊路由...
get('auth/register', 'AuthController@getRegister')->name('register');
post('auth/register', 'AuthController@postRegister');
get('auth/user-confirm', 'AuthController@getUserConfirm')->name('userConfirm');


get('/', 'HomeController@index')->name('home');
get('blog', 'HomeController@index_single')->name('blog');

Route::group(['middleware' => 'auth'], function () {
    get('blog/create', 'HomeController@create')->name('create');
    post('blog', 'HomeController@store');
    get('blog/{id}/edit', 'HomeController@edit');
    put('blog/{id}', 'HomeController@update');
    delete('blog/{id}', 'HomeController@destroy');

    get('password/reset_password', 'PasswordController@getResetPassword')->name('resetPassword');
    post('password/reset_password', 'PasswordController@postResetPassword');
});

get('blog/{id}', 'HomeController@show')->name('show');

get('password/forgot_password', 'PasswordController@getForgotPassword')->name('forgotPassword');
post('password/forgot_password', 'PasswordController@postForgotPassword');


