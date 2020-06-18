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

Route::group(['middleware' => 'isAdmin'], function() {
    Route::get( '/insert',  'MainController@new_user');
    Route::post('/add_user',  'MainController@add_user');
    Route::get('/edit/{id}','MainController@get_user');
    Route::put('/edit/{id}', 'MainController@edit_user');
    Route::get('/delete/{id}/','MainController@destroy');
});

