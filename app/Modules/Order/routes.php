<?php

Route::group(['prefix'=>'/orders'], function(){
	// Route::get('/', 'OrdersControllers@index');
	// Route::get('/{type}', 'OrdersControllers@getOrdersType');
 //    Route::get('information/{id}', 'OrdersControllers@show');
 //    Route::get('cancelOrder/{id}', 'OrdersControllers@cancelOrder');
 //    Route::get('delete/{id}', 'OrdersControllers@delete');

    Route::get('/images/icon', 'OrdersControllers@orderIcon')->middleware('svgImage');
    Route::post('/create_new', 'OrdersControllers@create');
    Route::get('/create_new/{code}', 'OrdersControllers@getOrder');
    Route::get('/create_new/{code}/changeDetails', 'OrdersControllers@changeDetails');
    Route::get('/create_new/{code}/getShipsByWeight', 'OrdersControllers@getShipsByWeight');
    Route::get('/create_new/{code}/getShipsSpec', 'OrdersControllers@getShipsSpec');
    Route::post('/create_new/{code}/storeOrderDetails', 'OrdersControllers@storeOrderDetails');
    Route::get('/complete_order/{code}', 'OrdersControllers@completeOrder');
    Route::post('/complete_order/{code}', 'OrdersControllers@saveOrder');

    Route::get('/lastSteps/{code}', 'OrdersControllers@lastSteps');
    Route::post('/changePerson/{id}', 'OrdersControllers@changePerson');
    Route::post('/changeDescription/{id}', 'OrdersControllers@changeDescription');

    Route::get('/lastSteps/{code}/offers', 'OrdersControllers@getOrderOffers');
    Route::post('/lastSteps/{code}/acceptOffer', 'OrdersControllers@acceptOffer');
    Route::post('/lastSteps/{code}/refuseOffer', 'OrdersControllers@refuseOffer');


    Route::post('/lastSteps/{code}/payment', 'OrdersControllers@payment');
    Route::get('/lastSteps/{code}/payment_success', 'OrdersControllers@payment_success');

    Route::post('/lastSteps/{code}/paypal', 'PaypalController@pay');
    Route::get('/lastSteps/{code}/paypal_success/{type}', 'PaypalController@paypal_success');
    Route::get('/lastSteps/{code}/paypal_failure', 'PaypalController@paypal_failure');


    Route::post('/delete_new/{id}', 'OrdersControllers@deleteOrder');


});