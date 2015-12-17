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
use Illuminate\Support\Facades\DB;
use Validator;
use Log;
use App\Libs\Error;
use App\Libs\Common;

class UserController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function reg(Request $request)
    {
        $request_url=$request->fullUrl();
        //echo $request_url;

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        //
    }


}
