<?php
/**
 * Created by PhpStorm.
 * User: lixiaoyu
 * Date: 15/12/17
 * Time: 上午9:53
 */

namespace App\Libs;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class Common
{


    /**
     * 加密字符串
     */
    public static function encryptString($string){

        return md5( (md5($string)) );
    }

    /**
     * 对象转化数组
     * @param $object
     * @return mixed
     */
    public  static function object2array($object) {
        if (is_object($object)) {
            foreach ($object as $key => $value) {
                $array[$key] = $value;
            }
        }
        else {
            $array = $object;
        }
        return $array;
    }


    /**
     * 验证token,返回当前用户的id
     * @param $token
     */
    public static function validateToken($token){

        try {
            $decrypted = Crypt::decrypt($token);
        } catch (DecryptException $e) {
            return false;
        }

        $str=base64_decode($decrypted);

        $login_info=explode("&&",$str);

        //检查时间
        $last_time=$login_info[0];
        $login_time=microtime(true);

       $remind= $login_time-$last_time;

        if($remind  > 36000){
            return false;
        }

        return $login_info[1];
    }

}