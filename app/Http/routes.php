<?php

use App\Task;
use Illuminate\Http\Request;


/**
 * Methods registered in the routing controller, it can not use the controller class and method name
 */

//引入REST的接口设计规范

//获取任务列表
Route::get('v1/tasks', 'TaskController@index');
//创建任务
Route::post('v1/tasks', 'TaskController@create');  //采用相同的url,用不同的http请求,做对应的处理

Route::post('v1/task/store', 'TaskController@store');

Route::get('v1/task/show/{id}', 'TaskController@show');

Route::get('v1/task/edit', 'TaskController@edit');

Route::put('v1/task/update', 'TaskController@update');

Route::delete('v1/task/destroy', 'TaskController@destroy');


Route::post('v1/user/reg', 'UserController@reg');

Route::post('v1/user/login', 'UserController@login');
