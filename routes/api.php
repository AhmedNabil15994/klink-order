<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix'=>'orders'], function () {


    // Route::post('/neworder', 'Frontend\OrderControllerApi@newOrder');
    // Route::post('/saveInformation', 'Frontend\OrderControllerApi@saveOrder');
    // Route::get('/getOrder/{orderId}', 'Frontend\OrderControllerApi@StoredOrder');
    // Route::post('/forgetOrder/{order}', 'Frontend\OrderControllerApi@forgetOrder');
    // 
});