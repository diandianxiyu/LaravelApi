<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Log;
use App\Libs\Error;
use App\Libs\Common;
use Illuminate\Support\Facades\Config;
use App\User;
use App\Task;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    /**
     * 用分页显示多个任务列表
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //通过参数进行验证
        //获取当前访问的全部的地址
        $request_url=str_replace("http://".Config::get('app.url'),"",$request->url());
        //参数验证
        //验证参数
        $validator = Validator::make($request->all(), [
            'page' => 'numeric',
            'per_page' => 'numeric',
            'token'=>'required'
        ]);

        //否则返回错误信息,并且做日志
        //验证参数完整性
        if ($validator->fails()) {
            // var_dump($validator);
            $error =  $validator->errors()->all();

            //写入日志
            Log::error(['error'=>$error,'request'=>$request->all(),'header'=>$request->headers,'client_ip'=>$request->getClientIp()]);
            //返回错误信息
//            return Error::returnError($request_url,2002);
            return  Response::create(json_encode($request_url),Response::HTTP_NOT_FOUND);
        }


        //验证token

//        $user_id=Common::validateToken($request->get('token'));
//
//        if($user_id == false){
//            return Error::returnError($request_url,2002);
//        }

        //分页获取记录,由于Api调用没有界面,所以这个分页还是通过数据库操作进行

        $page=$request->get('page')?$request->get('page'):0;
        $num=$request->get('num')?$request->get('num'):5;
        $list=Task::getListByPage($page,$num);

        $next_page=Task::getListNext($page,$num)?1:0;

        //返回对应的结果
        $json_arr=[
            'request'=>$request_url,
            'ret'=>[
                'list'=>$list,
                'next_page'=>$next_page
            ],
        ];

        return Common::returnResult($json_arr);

    }

    /**
     * post的方式添加一条记录
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request_url=str_replace("http://".Config::get('app.url'),"",$request->url());

        //验证参数
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            //'token'=>'required',
        ]);

        //验证参数完整性
        if ($validator->fails()) {
            $error =  $validator->errors()->all();
            //写入日志
            Log::error(['error'=>$error,'request'=>$request->all(),'header'=>$request->headers,'client_ip'=>$request->getClientIp()]);
            //返回错误信息
            return Error::returnError($request_url,1001);
        }

        //验证token

//        $user_id=Common::validateToken($request->get('token'));
//
//        if($user_id == false){
//            return Error::returnError($request_url,2002);
//        }

        $name=$request->get('name');

        //写入操作
        $add=Task::addTask($name);

        $info=Task::getTaskInfo($add);

        //返回对应的结果

        $json_arr=[
            'request'=>$request_url,
            'ret'=>$info,
        ];

        return Common::returnResult($json_arr);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        echo $id;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //接收图片

        var_dump($_FILES);

        //pic

        if ($request->hasFile('pic')) {
            //
            $request->file('pic')->move('upload', 'pic.png');
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
