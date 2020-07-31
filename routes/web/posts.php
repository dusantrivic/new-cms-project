<?php

use App\Role;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function(){
    Route::post('/posts','PostController@store')->name('post.store');
    Route::get('/posts','PostController@index')->name('post.index');

    Route::get('/posts/create','PostController@create')->name('post.create');

    Route::delete('/posts/{post}/destroy','PostController@destroy')->name('post.destroy');
    Route::patch('/posts/{post}/update','PostController@update')->name('post.update');
    Route::get('/posts/{post}/edit','PostController@edit')->middleware('can:view,post')->name('post.edit');
});



Route::get('/post/{post}','PostController@show')->name('post');
Route::get('/post/{post}/image','PostController@getImage')->name('post.image');
Route::get('/user/{user}/image','UserController@getUserImage')->name('user.image');
