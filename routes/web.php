<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'StaticPagesController@home');
Route::get('/help', 'StaticPagesController@help')->name('help');
Route::get('/about', 'StaticPagesController@about');
Route::resource('users','UsersController');

//会话控制路由 SessionController

Route::get('/login','SessionController@create')->name('login');
Route::post('/login','SessionController@store')->name('login');
Route::delete('/logout','SessionController@destroy')->name('logout');

//邮箱验证确认路由
Route::get('/signup/confirm/{token}','UsersController@confirmEmail')->name('confirm_email');

//密码重置路由
Route::get('password/reset','Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email','Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/request/{token}','Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset','Auth\ResetPasswordController@reset')->name('password.update');
//定义微博的创建、删除路由
Route::resource('statuses','StatusesController',['only'=> ['destroy','store']]);
