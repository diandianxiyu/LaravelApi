<?php
/**
 * 2015-12-15 14:12:01
 * Calvin userController
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Validator;
use Log;

class UserController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function reg(Request $request)
    {
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
            return $error;
        }



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
