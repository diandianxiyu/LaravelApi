<?php
/**
 * Created by PhpStorm.
 * User: lixiaoyu
 * Date: 15/12/17
 * Time: 上午9:55
 */

namespace App\Libs;

use App\Libs\Common;

class  Error{

    /**
     * 通过参数返回对应的错误数据的结果
     * @param $code
     * @param $arr
     */
    public static function returnError($request,$code){

        $error_code=[
            '1001'=>'参数不完整或者没有通过检测',
            '1002'=>'邮箱已经注册',
            '2001'=>'用户名或者密码不正确',
            '2002'=>'参数格式不正确',
        ];

        //找出对应的描述和错误代码
        $error_text=$error_code[$code];

        $error_array=[
            'request'=>$request,
            'error_code'=>$code,
            'error'=>$error_text,
        ];

        return Common::returnResult($error_array);
    }

}