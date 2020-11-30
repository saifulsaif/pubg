<?php

use Illuminate\Http\Request;

Route::get('/users', 'Api\LoginController@index');
Route::get('/getPartners', 'Api\HomeController@getPartners');
Route::post('/banner', 'Api\HomeController@banner');
Route::get('/getSliders', 'Api\HomeController@getSliders');
Route::post('/registration', 'Api\HomeController@registration');
Route::get('clear_waiting_list', 'Api\HomeController@clear_waiting_list');

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('profile', 'AuthController@profile');
    Route::post('short_profile', 'AuthController@short_profile');
    Route::post('profile_update', 'AuthController@profileUpdate');
    Route::post('contact', 'AuthController@contact');
    Route::post('send', 'AuthController@send');
    Route::post('update_device_id', 'AuthController@updateDeviceID');
    Route::post('message_list', 'AuthController@messageList');
    Route::post('active_users', 'AuthController@activeUsers');
    Route::post('chat_list', 'AuthController@chatList');
    Route::post('seller_send_messages', 'Api\MessageController@sellerSendMessage');
    Route::post('user_send_messages', 'Api\MessageController@userSendMessage');
    Route::post('seller_contact', 'AuthController@seller_contact');
    Route::post('online_status', 'AuthController@online_status');
    Route::post('unseen', 'AuthController@unseen');
    Route::post('user_inbox', 'AuthController@user_inbox');
    Route::post('waiting_position', 'AuthController@waiting_position');
    Route::post('profile_image_update', 'AuthController@image_upload');
    Route::post('purchase', 'AuthController@purchase');
    Route::post('point', 'AuthController@point');
    Route::post('favorite', 'AuthController@favorite');
    Route::post('note', 'AuthController@note');
    Route::post('partials-info', 'AuthController@partialInfo');
    Route::post('referral', 'AuthController@referral');
    Route::post('waiting_list', 'Api\MessageController@waiting_list');
    Route::post('clear_waiting_list', 'Api\MessageController@clear_waiting_list');
    Route::post('start_chat', 'Api\MessageController@start_chat');
    Route::post('send_messages', 'Api\MessageController@SendMessage');

    Route::post('product_list', 'Api\ProductController@product_list');
    Route::post('set_point', 'AuthController@set_point');
    Route::post('referral_point_list', 'AuthController@referral_point_list');
    Route::post('sell', 'Api\SellController@sell');
    Route::post('get_seller_sells', 'Api\SellController@get_seller_sells');
    Route::post('get_user_sells', 'Api\SellController@get_user_sells');
    Route::post('sell_cancel', 'Api\SellController@sell_cancel');
    Route::post('sell_approve', 'Api\SellController@sell_approve');
    Route::post('seller_list', 'Api\SellController@seller_list');
    Route::post('seller_transfer', 'Api\SellController@seller_transfer');


    Route::post('password_change','AuthController@password_change');
    Route::post('check_number','AuthController@check_number');
    Route::post('rest_password','AuthController@rest_password');
});
