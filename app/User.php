<?php

namespace App;

use App\Libs\Common;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class User extends Model
{
    //


    /**
     * 查询是不是有这个用户注册了邮件
     * @param $email
     */
    public static function checkUserExist($email){
//        $model=new User();
//        $model->email=$email;
//        $model->query();
//        return $model->exists;
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


}
