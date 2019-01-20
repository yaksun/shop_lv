<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::any('admin/login','Admin\LoginController@login');
Route::get('admin/code','Admin\LoginController@code');

Route::group(['middleware'=>'admin_login','prefix'=>'admin','namespace'=>'Admin'],function (){

    //后台首页路由
    Route::get('index','IndexController@index');
    Route::get('info','IndexController@info');
    Route::get('quit','LoginController@quit');

    //分类资源路由
    Route::resource('category','CategoryController');


    //活动资源路由
    Route::resource('event','EventController');
    Route::any('event/changeorder','EventController@changeOrder');

    //商品资源路由
    Route::resource('goods','GoodsController');
    Route::any('goods/upload','GoodsController@upload');
});








