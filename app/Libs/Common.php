<?php
/**
 * Created by PhpStorm.
 * User: lixiaoyu
 * Date: 15/12/17
 * Time: 上午9:53
 */

namespace App\Libs;


class Common
{
    /**
     * 返回结果
     * @param $arr
     * @return string
     */
    public static function returnResult($arr){
        return json_encode($arr);
    }


    /**
     * 加密字符串
     */
    public static function encryptString($string){

        return md5( (md5($string)) );
    }

}