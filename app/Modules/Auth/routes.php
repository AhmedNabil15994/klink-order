<?php

/*----------------------------------------------------------
User Auth
----------------------------------------------------------*/
Route::group(['prefix' => '/'] , function () {
    Route::get('login', 'DomainAuthController@getLogin');
    Route::get('/dashboard', 'DomainAuthController@index')->middleware('user:web');
    Route::post('/login', 'DomainAuthController@postLogin');
    Route::get('/password/reset','DomainAuthController@getReset');
    Route::get('/register','DomainAuthController@getRegister');

    Route::get('logout', 'DomainAuthController@logout')->middleware('user:web');
});
