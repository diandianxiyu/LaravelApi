<?php

namespace App;

use App\Libs\Common;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class User extends Model
{
    //


    /**
     * 查询是不是有这个用户注册了邮件
     * @param $email
     */
    public static function checkUserExist($email){
        $model=User::where("email",$email)->get();

        if(count($model)){
            return true;
        }
        return false;
    }


    /**
     * 添加用户
     * @param $name
     * @param $email
     * @param $password
     */
    public static function AddUser($name,$email,$password){

        $model=new User();
        $model->email=$email;
        $model->name=$name;
        $model->password=Common::encryptString($password);
        $model->save();

        return $model->id;
    }

    /**
     * 返回用户的基本信息
     * @param $id
     */
    public static function getUserInfo($id){

        $model=User::where("id",$id)->get();

        $att_arr=$model[0]->attributes;

        unset($att_arr['id']);
        unset($att_arr['password']);
        unset($att_arr['remember_token']);

        return $att_arr;

    }


    /**
     * 检查登录
     * @param $email
     * @param $password
     * @return bool
     */
    public static function checkUserLogin($email,$password){
        $model=User::where("email",$email)->where("password",Common::encryptString($password))->get();

        if(count($model)){
            return $model[0];
        }
        return false;
    }


    /**
     * 更新token
     * @param $user
     */
    public static function updateToken($user){

        //采用自带的加密方式,对token进行加密保存
        //自己加密,保存,用于验证和传输过程中解密

        $login_time=microtime(true);

        $id=$user->id;

        $token=base64_encode($login_time."&&".$id);


        $token_login=Crypt::encrypt($token);


        $user->remember_token=$token;

        $user->save();


        return $token_login;

    }


}
