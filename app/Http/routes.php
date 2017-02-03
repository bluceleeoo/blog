<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


//Route::get('/','IndexController@index');

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    Route::get('/','Home\IndexController@index');
    Route::get('/cate/{cate_id}', 'Home\IndexController@cate');
    Route::get('/a/{art_id}', 'Home\IndexController@article');

    Route::any('admin/login','Admin\LoginController@login');
    Route::get('admin/code','Admin\LoginController@code');
    //Route::any('admin/crypt','Admin\LoginController@crypt');
});

Route::group(['middleware' => ['web','admin.login'],'prefix'=>'admin','namespace'=>'Admin'], function () {
    Route::get('index','IndexController@index');
    Route::get('info','IndexController@info');
    Route::get('quit','LoginController@quit');
    Route::any('pass','IndexController@pass');
    Route::post('cate/changeorder','CategoryController@changeOrder');
    Route::resource('category','CategoryController');

    Route::resource('article','ArticleController');
    Route::resource('links','LinksController');
    Route::post('links/changeorder','LinksController@changeOrder');
    Route::any('upload','CommonController@upload');
    Route::resource('navs','NavsController');
    Route::post('navs/changeorder','NavsController@changeOrder');
    Route::get('config/putfile','ConfigController@putFile');
    Route::resource('config','ConfigController');
    Route::post('config/changeorder','ConfigController@changeOrder');
    Route::post('config/changecontent','ConfigController@changeContent');


});
