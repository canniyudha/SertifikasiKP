<?php

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
    return redirect('post');
});

Route::resource('post', 'PostController')->except(['create', 'edit']);

Route::resource('profile', 'ProfileController')->except(['index', 'create', 'store']);

Route::resource('comment', 'CommentController')->only(['store', 'update', 'destroy']);

Route::post('/comment/{comment}/create', 'CommentController@create')->name('comment.create');

Route::post('/post/{post}', 'PostController@like')->name('post.like');

Route::post('/comment/{comment}', 'CommentController@like')->name('comment.like');

Route::post('/profile/{profile}', 'ProfileController@follow')->name('profile.follow');

Auth::routes();

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
