<?php


Route::get('/', function () {
    return view('welcome');
});

Route::get('/overview', function () {
    return view('home');
});

Route::get('/home', function () {
    return view('home');
});

Route::get('/group/{id}', function () {
    return view('home');
});

Route::get('/users', function () {
    return view('home');
});

Route::get('/developer', function () {
    return view('home');
});

Route::get('/profile', function () {
    return view('home');
});

Route::get('/app', function () {
    return view('home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('invoice', function(){
    return view('invoice');
});

Route::get('{path}',"HomeController@index")->where( 'path', '([A-z\d-\/_.]+)?' );
