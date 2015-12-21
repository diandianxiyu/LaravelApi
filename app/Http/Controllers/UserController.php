<?php
/**
 * 2015-12-15 14:12:01
 * Calvin userController
 */

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Validator;
use Log;
use App\Libs\Error;
use App\Libs\Common;
use Illuminate\Support\Facades\Config;

class UserController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function reg(Request $request)
    {
        $request_url=str_replace("http://".Config::get('app.url'),"",$request->url());

        //验证参数
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        //验证参数完整性
        if ($validator->fails()) {
            // var_dump($validator);
            $error =  $validator->errors()->all();
            //写入日志
            Log::error(['error'=>$error,'request'=>$request->all(),'header'=>$request->headers,'client_ip'=>$request->getClientIp()]);
            //返回错误信息
            return Error::returnError($request_url,1001);
        }

        $name=$request->get('name');

        $email=$request->get('email');

        $password=$request->get('password');

        //数据库相关的操作
        $exist=User::checkUserExist($email);


        if($exist){
            return Error::returnError($request_url,1002);
        }
        //写入操作
        $add=User::AddUser($name,$email,$password);

        $info=User::getUserInfo($add);

        //返回对应的结果

        $json_arr=[
            'request'=>$request_url,
            'ret'=>$info,
        ];

        return Common::returnResult($json_arr);

    }

    /**
     * 用户通过邮箱和密码进行登录操作
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        //获取当前访问的全部的地址
        $request_url=str_replace("http://".Config::get('app.url'),"",$request->url());

        //验证参数
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        //验证参数完整性
        if ($validator->fails()) {
            // var_dump($validator);
            $error =  $validator->errors()->all();

            //写入日志
            Log::error(['error'=>$error,'request'=>$request->all(),'header'=>$request->headers,'client_ip'=>$request->getClientIp()]);
            //返回错误信息
            return Error::returnError($request_url,1001);
        }

        $email=$request->get('email');

        $password=$request->get('password');

        //检查有没有
        $user_model=User::checkUserLogin($email,$password);

        if($user_model == false){
            return Error::returnError($request_url,2001);
        }

        //更新token
       $token= User::updateToken($user_model);

        //返回对应的结果

        $json_arr=[
            'request'=>$request_url,
            'ret'=>User::getUserInfo($user_model->id),
            'token'=>$token
        ];

        return Common::returnResult($json_arr);
    }


}
