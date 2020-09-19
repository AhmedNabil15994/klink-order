<?php

/*----------------------------------------------------------
Home
----------------------------------------------------------*/
Route::group(['prefix' => '/','middleware'=>'Language'] , function () {
    Route::get('/', 'HomeController@index');


    Route::get('/401', function(){
    	return view('errors.401');
    });
    Route::get('/404', function(){
    	return view('errors.404');
    });
    Route::get('/503', function(){
    	return view('errors.503');
    });



    Route::get('/js/lang-{lang}.js', function ($lang) {
	    // return $lang;
	    Cache::forget('lang-'.$lang.'.js');
	    $strings = Cache::remember('lang-{$lang}.js', 0, function () use ($lang) {
	        
	        // return $lang;
	        $files   = glob(resource_path('lang/' . $lang . '/*.php'));
	        $files2 = glob(resource_path('lang/' . $lang . '/front/*.php'));
	        $files3 = glob(resource_path('lang/' . $lang . '/frontend/*.php'));
	        $files4 = glob(resource_path('lang/' . $lang . '/backend/*.php'));
	        
	        $strings = [];
	        foreach ($files2 as $file) {
	            $name   = basename($file, '.php');
	            $strings['front'][$name] = require $file;
	        }
	        foreach ($files as $file) {
	            $name   = basename($file, '.php');
	            $strings[$name] = require $file;
	        }
	        foreach ($files3 as $file) {
	            $name   = basename($file, '.php');
	            $strings['frontend'][$name] = require $file;
	        }
	        foreach ($files4 as $file) {
	            $name   = basename($file, '.php');
	            $strings['backend'][$name] = require $file;
	        }
	        
	        return $strings;
	    });

	    header('Content-Type: text/javascript');
	    echo('window.i18n =  ' . json_encode($strings) . ';');
	    exit();
	})->name('assets.lang');



});
