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

}