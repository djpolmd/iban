<?php


Route::get('/', 'MainController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/iban', 'MainController@iban')->name('form');

