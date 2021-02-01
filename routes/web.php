<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

//HOME
Route::get('/', 'HomeController@index')->name('home');

//LOGIN/REGISTRAZIONE
Auth::routes();

//PUBLIC
Route::get('posts', 'PostController@index')->name('posts.index');
Route::get('posts/{slug}', 'PostController@show')->name('posts.show');

//Tutto ciò che indichiamo qua dentro sarà protetto da auth
Route::prefix('admin')  //Si indica la parte che si bule nell URL
     ->namespace('Admin')  //Namespace dove pescare i controller
     ->name('admin.')  //La parte che voglio mettere sempre prima della rotta che passo più sotto per non creare conflitto con altre rotte
     ->middleware('auth')
     ->group(function(){
        //Home Admin (Dashboard)
        Route::get('/', 'HomeController@index')->name('home');

        //Rotte CRUD Post
        Route::resource('posts', 'PostController');
    });
