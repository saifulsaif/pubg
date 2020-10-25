<?php

use Illuminate\Http\Request;

Route::get('/users', 'Api\LoginController@index');
Route::get('/getPartners', 'Api\HomeController@getPartners');
Route::get('/getSliders', 'Api\HomeController@getSliders');
Route::post('/registration', 'Api\HomeController@registration');

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('profile', 'AuthController@profile');
    Route::post('profile-update', 'AuthController@profileUpdate');
    Route::post('contact', 'AuthController@contact');
    Route::post('send', 'AuthController@send');

});
