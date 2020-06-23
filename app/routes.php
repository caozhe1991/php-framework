<?php
use lib\Route;
/**
 * Created by PhpStorm.
 * User: dzg
 * Date: 2018/5/15
 * Time: 15:03
 */

// Group = Auth.表示需要用户登陆；Admin.表示仅管理员可访问

//登录页面
Route::get('/login', 'LoginController@showIndex');

Route::get('/logout', 'LoginController@logout', 'Auth');

//登录提交路由
Route::post('/login/auth', 'LoginController@login');

Route::get('/', 'IndexController@showIndex', ['Auth','Admin']);

//自动登录
Route::get('/auto/login', 'LoginController@autoLogin');

//查看反馈信息页面
Route::get('/show/feedback/item', 'FeedbackController@showFeedbackItem', 'Auth');

//添加反馈信息页面
Route::get('/add/feedback/view', 'FeedbackController@showAddFeedbackView', 'Auth');

//提交反馈信息
Route::post('/add/feedback/item','FeedbackController@AddFeedbackItem', 'Auth');

//完成反馈信息
Route::get('/set/feedback/over', 'FeedbackController@overFeedback', 'Auth');

//反馈信息列表
Route::get('/show/feedback/list', 'FeedbackController@getFeedbackList', 'Auth');

//提交回复消息
Route::post('/add/feedback/reply', 'ReplyController@addReply',  'Auth');

//上传图片
Route::post('/upload/image', 'ImageController@uploadImage', 'Auth');

//用户列表
Route::get('/user/lists/view', 'UserController@userListView',['Auth','Admin']);
//添加用户页面
Route::get('/user/add/view', 'UserController@addUserView',['Auth','Admin']);
//添加用户页面
Route::post('/user/add/date', 'UserController@addUserItem',['Auth','Admin']);
//删除用户
Route::get('/user/del/data', 'UserController@delUser',['Auth','Admin']);
//自助注册页面
//Route::get('/user/register/view', 'UserController@selfRegisterView');
//自助注册
Route::post('/self/user/add/date','UserController@selfRegisterData');
//检查用户是否存在
Route::post('/api/check-user', 'Api\UserApi@checkUser', 'Api');
//获取文章列表
Route::get('/api/get-article-list', 'Api\ArticleApi@getList', 'Api');
//获取文章详细内容
Route::get('/api/get-article-detail', 'Api\ArticleApi@getDetail', 'Api');

//授权管理
Route::get('/devices-manage', 'DevicesManageController@index', 'Admin');
Route::post('/devices-manage-list', 'DevicesManageController@getList', 'Admin');

Route::get('/devices-manage-add-view', 'DevicesManageController@addView', 'Admin');
Route::post('/devices-manage-add', 'DevicesManageController@add', 'Admin');

Route::get('/devices-manage-del', 'DevicesManageController@del', 'Admin');

Route::get('/device-activation-view', 'DevicesManageController@activationView', 'Token');
Route::post('/device-activation', 'DevicesManageController@activation', 'Token');

//来自设备请求授权KEY
Route::post('/device-activation-key', 'DevicesManageController@getDeviceKey', 'token');













/**
 * 以下路由是配合 device-check 工具做检查使用
 */

Route::get("/device-check/test-connect", "Api\DeviceCheck\TestConnectController@connect");
Route::get("/device-check/database-table-total", "Api\DeviceCheck\DatabaseController@databaseTableNumber");

Route::get("/device-check/database-table-list", "Api\DeviceCheck\DatabaseController@getTableList");
Route::get("/device-check/database-table-struct", "Api\DeviceCheck\DatabaseController@getTableStruct");
