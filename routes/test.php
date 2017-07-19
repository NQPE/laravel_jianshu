<?php
/**
 * Created by PhpStorm.
 * User: Levi
 * Date: 2017/7/10
 * Time: 18:16
 */

//解析html
Route::get('/testparse','TestController@parseHtml');

//上传多图页面
Route::get('/testfile','TestController@testfile');

//上传多图
Route::post('/upload/images','TestController@uploadImages');

