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

/**
 * 文章模块
 */

//文章列表页
Route::get('/posts','PostController@index');
//文章详情页
Route::get('/posts/show/{post}','PostController@show');
//创建文章
Route::get('/posts/create','PostController@create');
Route::post('/posts/store','PostController@store');
//编辑文章
Route::get('/posts/edit/{post}','PostController@edit');
Route::post('/posts/update/{post}','PostController@update');
//删除文章
Route::get('/posts/delete/{post}','PostController@delete');
//上传图片
Route::post('/posts/upload/images','PostController@uploadImages');
//发表图片
Route::post('/posts/comment/{post}','PostController@comment');
//赞文章
Route::get('/posts/zan/{post}','PostController@zan');
//取消赞文章
Route::get('/posts/unzan/{post}','PostController@unzan');
//搜索
Route::get('/posts/search','PostController@search');

/**
 * 用户模块
 */

//注册页面
Route::get('/register','RegisterController@index');
//注册操作
Route::post('/register','RegisterController@register');
//登录页面
Route::get('/login','LoginController@index');
//登录操作
Route::post('/login','LoginController@login');
//登出操作
Route::get('/logout','LoginController@logout');
//个人设置页面
Route::get('/user/me/setting','UserController@setting');
//个人设置操作
Route::post('/user/me/setting','UserController@settingStore');

/**
 * 个人中心模块
 */
//个人中心页面
Route::get('/user/index/{user}','UserController@index');
//关注某人
Route::post('/user/fan/{user}','UserController@fan');
//取关某人
Route::post('/user/unfan/{user}','UserController@unfan');

/**
 * 专题模块
 */
//专题详情页
Route::get('/topic/{topic}','TopicController@show');
//投稿
Route::post('/topic/submit/{topic}','TopicController@submit');

/**
 * 通知
 */
//系统通知页面
Route::get('/notices','NoticeController@index');