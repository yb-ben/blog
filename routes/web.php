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

Route::get('/', function () {
    return view('index');
});


Route::prefix('admin')->group(function () {

    Route::prefix('login')->group(function(){
       Route::view('login.html','admin.login.login') ;
    });

    Route::prefix('layout')->group(function (){

        Route::prefix('index')->group(function () {
            Route::view('index.html', 'admin.layout.index.index');
        });
        Route::prefix('admin')->group(function () {
            Route::view('index.html', 'admin.layout.admin.index');
        });
        Route::prefix('role')->group(function () {
            Route::view('index.html', 'admin.layout.role.index');
        });

        Route::prefix('video')->group(function () {
            Route::view('index.html', 'admin.layout.video.index');
        });



        Route::view('test.html', 'admin.layout.test');
        Route::view('test2.html', 'admin.layout.test2');
    });

    Route::view('index.html', 'admin.index');

});


Route::namespace('admin')->prefix('admin')->group( function () {

    Route::prefix('login')->group(function () {
        Route::post('loginPwd', 'LoginController@loginPwd');
    });

    //管理员
    Route::prefix('admin')->group(function(){


            Route::get('list','AdminController@list');
    });

    //首页
    Route::prefix('index')->group(function(){
            Route::get('index', 'IndexController@index');
        });

    //权限
    Route::prefix('auth')->group(function(){
            Route::get('list', 'AuthController@list');
            Route::post('add', 'AuthController@add');
        });

    //分组
    Route::prefix('group')->group(function(){
            Route::get('list','GroupController@list');
            Route::post('add/{pid}','GroupController@add');
        });

    //角色
    Route::prefix('role')->group(function(){
        Route::get('list','RoleController@list');
        Route::post('add/{pid}','RoleController@add');
    });

    //测试
    Route::prefix('test')->group(function () {
        Route::post('upload','TestController@upload');
        Route::get('test','TestController@test');
        Route::post('check', 'TestController@check');
        Route::post('mergeChunk', 'TestController@mergeChunk');

        Route::post('_chunkUpload', 'TestController@_chunkUpload');
    });

});



