<?php

use Illuminate\Http\Request;

Route::get('/users', 'Api\LoginController@index');
Route::get('/getPartners', 'Api\HomeController@getPartners');
Route::post('/banner', 'Api\HomeController@banner');
Route::get('/getSliders', 'Api\HomeController@getSliders');
Route::post('/registration', 'Api\HomeController@registration');

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('profile', 'AuthController@profile');
    Route::post('profile_update', 'AuthController@profileUpdate');
    Route::post('contact', 'AuthController@contact');
    Route::post('send', 'AuthController@send');
    Route::post('update_device_id', 'AuthController@updateDeviceID');
    Route::post('message_list', 'AuthController@messageList');
    Route::post('active_users', 'AuthController@activeUsers');
    Route::post('chat_list', 'AuthController@chatList');
    Route::post('send_messages', 'AuthController@sendMessage');
    Route::post('seller_contact', 'AuthController@seller_contact');
    Route::post('online_status', 'AuthController@online_status');
    Route::post('unseen', 'AuthController@unseen');
    Route::post('watting_position', 'AuthController@watting_position');

});
