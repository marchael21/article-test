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
    // return view('welcome');
    return redirect()->route('home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/profile/{user_name}', 'HomeController@profile')->name('profile');
Route::post('/updateProfile', 'HomeController@updateProfile')->name('updateProfile');

// article route
Route::group(['prefix'=>'article', 'as' => 'article.'], function() {
	Route::redirect('/', 'article/list');
	Route::get('list', 'ArticleController@index')->name('list')->middleware(['stripEmptyParams']);	
	Route::get('create', 'ArticleController@create')->name('create');
	Route::get('view/{id}', 'ArticleController@show')->name('show');
    Route::get('edit/{id}', 'ArticleController@edit')->name('edit');
    Route::post('submit', 'ArticleController@store')->name('store');
    Route::patch('update/{id}', 'ArticleController@update')->name('update');
    Route::delete('delete/{id}', 'ArticleController@destroy')->name('delete');
});

// admin routes
Route::group(['middleware' => 'admin', 'as' => 'admin.'], function () {
	// user routes
	Route::group(['prefix'=>'user', 'as' => 'user.'], function() {
	    Route::redirect('/', 'user/list');
	    Route::get('list', 'UserController@index')->name('list')->middleware(['stripEmptyParams']);
	    Route::get('create', 'UserController@create')->name('create');
	    Route::get('edit/{id}', 'UserController@edit')->name('edit');
	    Route::post('submit', 'UserController@store')->name('store');
	    Route::patch('update/{id}', 'UserController@update')->name('update');
	    Route::delete('delete/{id}', 'UserController@destroy')->name('delete');
	});
});
