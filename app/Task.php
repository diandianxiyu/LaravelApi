<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Libs\Common;

class Task extends Model
{


    /**
     * 添加任务,返回id
     * @param $name
     */
    public static function addTask($name){
        $model=new Task();
        $model->name=$name;
        $model->save();
        return $model->id;

    }


    /**
     * 返回基本信息
     * @param $id
     */
    public static function getTaskInfo($id){

        $model=Task::where("id",$id)->get();

        $att_arr=$model[0]->attributes;

        unset($att_arr['id']);

        return $att_arr;

    }


    /**
     * 分页获取列表
     * @param int $page
     * @param int $num
     */
    public static function getListByPage($page=0,$num=5){
        //$model=new Task();
       // $model->offsetSet($page*$num,$num);
        $list=DB::table('tasks')->orderBy('created_at', 'desc')->skip($page*$num)->take($num)->get();

        $arr=[];
        if(count($list)){
            foreach($list as  $value){
                $arr_per=Common::object2array($value);
                unset($arr_per['id']);
                $arr[]=$arr_per;
            }
        }
        return $arr;
    }

    /**
     * 下一页是不是还有
     * @param int $page
     * @param int $num
     * @return bool
     */
    public static function getListNext($page=0,$num=5){
        $page++;
        $list=DB::table('tasks')->orderBy('created_at', 'desc')->skip($page*$num)->take($num)->get();
        if(count($list)){
            return true;
        }
        return false;
    }
}
