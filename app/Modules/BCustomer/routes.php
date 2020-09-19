<?php

/*----------------------------------------------------------
Business Customer
----------------------------------------------------------*/
Route::group(['prefix' => '/business_customer'] , function () {
    Route::get('/', 'BCustomerController@index');
});
