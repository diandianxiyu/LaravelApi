<?php

use App\Task;
use Illuminate\Http\Request;


/**
 * Methods registered in the routing controller, it can not use the controller class and method name
 */
Route::get('task/index', 'TaskController@index');
Route::get('task/create', 'TaskController@create');
Route::post('task/store', 'TaskController@store');
Route::get('task/show', 'TaskController@show');
Route::get('task/edit', 'TaskController@edit');
Route::put('task/update', 'TaskController@update');
Route::delete('task/destroy', 'TaskController@destroy');


Route::post('user/reg', 'UserController@reg');
Route::post('user/login', 'UserController@login');
