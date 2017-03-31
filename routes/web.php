<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'Frontend\PageController@index')->name('canvas.home');

Route::get('/blog/post/{slug}', 'Frontend\BlogController@showPost')->name('canvas.blog.post.show');

Route::get('/contact-maddie-raspe', 'Frontend\PageController@contact');

Route::get('/search', 'Frontend\PageController@search');