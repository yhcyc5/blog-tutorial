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
get('auth/user-confirm', 'AuthController@getUserConfirm')->name('user-confirm');


get('/', 'HomeController@home')->name('home');
get('blog', 'HomeController@blog')->name('blog');

Route::group(['middleware' => 'auth'], function () {
    get('blog/create', 'HomeController@create')->name('create-post');
    post('blog', 'HomeController@store');
    get('blog/{id}/edit', 'HomeController@edit');
    put('blog/{id}', 'HomeController@update');
    delete('blog/{id}', 'HomeController@destroy');

    get('auth/reset_password', 'AuthController@getResetPassword')->name('reset-password');
    post('auth/reset_password', 'AuthController@postResetPassword');
});

get('blog/{id}', 'HomeController@show')->name('show-post');

get('auth/forgot_password', 'AuthController@getForgotPassword')->name('forgot-password');
post('auth/forgot_password', 'AuthController@postForgotPassword');


