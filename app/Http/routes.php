<?php
use Illuminate\Routing\Route;
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


Route::get('post', 'HomeController@index'); // My Blog
Route::get('post/create', 'HomeController@create'); // Create Post
Route::post('post', 'HomeController@store');
Route::get('post/{id}', 'HomeController@show'); // Update Post
Route::get('post/{id}/edit', 'HomeController@edit');
Route::put('post/{id}', 'HomeController@update');