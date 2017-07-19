<?php
//登录页面
Route::get('/login', 'LoginController@index');
//登录逻辑
Route::post('/login', 'LoginController@login');
//登出逻辑
Route::get('/logout', 'LoginController@logout')->middleware('auth:admin');

Route::group(['middleware'=>'auth:admin'],function(){
    //首页
    Route::get('/index', 'HomeController@index');

    /**
     * 系统管理模块
     */
    Route::group(['middleware'=>'can:system'],function(){

        //用户列表
        Route::get('/users', 'UserController@index');
        //创建用户页面
        Route::get('/users/create', 'UserController@create');
        //创建用户逻辑
        Route::post('/users/store', 'UserController@store');

        //用户角色关联页面
        Route::get('/users/role/{user}', 'UserController@role');
        //用户角色关联逻辑
        Route::post('/users/role/{user}', 'UserController@storeRole');

        //角色列表页面
        Route::get('/roles', 'RoleController@index');
        //添加角色页面
        Route::get('/roles/create', 'RoleController@create');
        //添加角色逻辑
        Route::post('/roles/store', 'RoleController@store');

        //权限角色关联页面
        Route::get('/roles/permission/{role}', 'RoleController@permission');
        //用户角色关联逻辑
        Route::post('/roles/permission/{role}', 'RoleController@storePermission');

        //权限列表页面
        Route::get('/permissions', 'PermissionController@index');
        //添加权限页面
        Route::get('/permissions/create', 'PermissionController@create');
        //添加权限逻辑
        Route::post('/permissions/store', 'PermissionController@store');
    });

    /**
     * 文章管理模块
     */
    Route::group(['middleware'=>'can:post'],function(){
        //文章列表
        Route::get('/posts', 'PostController@index');
        //文章操作
        Route::post('/posts/status/{post}', 'PostController@status');
    });
    /**
     * 专题管理模块
     */
    Route::group(['middleware'=>'can:topic'],function(){
        //专题列表
        Route::get('/topics', 'TopicController@index');
        //创建专题页面
        Route::get('/topics/create', 'TopicController@create');
        //创建专题操作
        Route::post('/topics/store', 'TopicController@store');
        //删除专题操作
        Route::post('/topics/delete/{topic}', 'TopicController@delete');
    });

    /**
     * 通知管理模块
     */
    Route::group(['middleware'=>'can:notice'],function(){
//        Route::resource('notices','NoticeController',['only'=>['index','create','store']]);
        //专题列表
        Route::get('/notices', 'NoticeController@index');
        //创建专题页面
        Route::get('/notices/create', 'NoticeController@create');
        //创建专题操作
        Route::post('/notices/store', 'NoticeController@store');
    });



});
