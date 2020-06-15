<?php


Route::get('/', 'MainController@index');

Auth::routes();

Route::get('/iban', 'MainController@iban')->name('form');

Route::group(['middleware' => 'auth'], function() {

    Route::get('/admin/post_form', 'MainController@post_form'); // admin main form
    Route::get('/admin/user_roles', 'MainController@user_form');

    Route::get('/iban', 'MainController@iban')->name('iban');
    Route::get('/home', 'MainController@iban')->name('iban');


});
