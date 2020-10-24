<?php

Auth::routes();
 //Start Font end............................
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

// End fontend............................


// Start Admin site.....................
Route::get('/admin/dashboard', 'AdminController@index')->name('admin');
Route::get('/admin/slider', 'AdminController@slider')->name('slider');
Route::post('/admin/save', 'AdminController@sliderSave')->name('slider.save');
Route::get('/admin/slider/delete/{id}', 'AdminController@sliderDelete')->name('slider.delete');

// Route::post('/admin/save', 'AdminController@sliderSave')->name('slider.save');
// Route::get('/admin/slider/delete/{id}', 'AdminController@sliderDelete')->name('slider.delete');

Route::get('/admin/users', 'AdminController@Users')->name('users');
Route::get('/admin/admins', 'AdminController@Admins')->name('admins');
Route::post('/admin/add/admin', 'AdminController@saveAdmin')->name('add.admin');
Route::get('/admin/admin/delete/{id}', 'AdminController@adminDelete')->name('admin.delete');


Route::get('/admin/setting', 'AdminController@setting')->name('setting');
Route::post('admin/setting/update','AdminController@settingUpdate')->name('setting.update');

Route::get('/admin/terms', 'AdminController@terms')->name('admin.terms');
Route::post('admin/terms/update','AdminController@updateTerms')->name('update.terms');

Route::get('/admin/policy', 'AdminController@policy')->name('admin.policy');
Route::post('admin/policy/update','AdminController@updatePolicy')->name('update.policy');

// End Admin Site....................................
