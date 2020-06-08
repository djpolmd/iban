<?php


Route::get('/', 'MainController@index');

Auth::routes();

Route::get('/iban', 'MainController@iban')->name('form');

Route::get('/home', 'MainController@iban')->name('index');

Route::group(['middleware' => 'auth'], function() {

    Route::get('/post_form', 'MainController@post_form');
    Route::get('/iban', 'MainController@iban');

});
