<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/27
 * Time: 10:19
 */

namespace App\Models\Traits;

use Redis;
use Carbon\Carbon;


trait  LastActivedAtHelper
{

    // 缓存相关
    protected $hash_prefix = 'larabbs_last_actived_at_';
    protected $field_prefix = 'user_';

    //每次访问将当前时间写入redis中
    //在middleware中调用此方法，并且把middleware在app\http\kernel中注册成全局中间件
    public function recordLastActivedAt()
    {
        //获取当前时间
        $date = Carbon::now()->toDateString();

        // Redis 哈希表的命名，如：larabbs_last_actived_at_2017-10-21
        $hash_table = $this->getFormatHashPrefix($date);

        // 字段名称，如：user_1
        $field = $this->getFormatFieldPrefix();
        //dd(Redis::hGetAll($hash_table));
        // 当前时间，如：2017-10-21 08:35:15
        $now = Carbon::now()->toDateTimeString();

        // 数据写入 Redis ，字段已存在会被更新
        Redis::hSet($hash_table, $field, $now);

    }



    //将用户最后登录时间从 Redis 同步到数据库中
    public function syncUserActivedAt()
    {

        //获取昨天的时间
        $yesterday_date = Carbon::yesterday()->toDateString();
        //$yesterday_date = Carbon::now()->toDateString();

        $hash = $this->getFormatHashPrefix($yesterday_date);

        $dates = Redis::hGetAll($hash);
        //循环数组插入user数据库相应的字段
        foreach($dates as $user_id => $actived_at){
            //替换如 user_1 中的user_ 获取到id
            $id = str_replace($this->field_prefix,'',$user_id);
            //如果在表中科院查询到此id 修改此id所在列 last_actived_at字段的值
            if($user = $this->find($id)){

                $user->last_actived_at = $actived_at;
                $user->save();
            }

        }

        //同步完成后删除redis中缓存
        Redis::del($hash);
        
    }


    //访问器获取用户最后活跃时间

    public function getLastActivedAtAttribute($value)
    {

        //获取hash表名
        $hash = $this->getFormatHashPrefix(Carbon::now()->toDateString());
        //获取hash字段名
        $field = $this->getFormatFieldPrefix();
        //获取hash表中保存的对应值，如果不存在则获取数据库中此字段的值
        $active_at = Redis::hGet($hash ,$field)? : $value;
        if($active_at){

            //如果存在 则返回Carbon对象
            return new Carbon($active_at); //把时间转换成Carbon对象

        }else{

            return $this->created_at;   //实例中的 created_at和updated_at会自动转换成Carbon对象
        }
        
    }


    //获取hash表名
    public function getFormatHashPrefix($data)
    {
        return $this->hash_prefix.$data;
    }

    //获取hash表中的字段名
    public function getFormatFieldPrefix()
    {

        return $this->field_prefix.$this->id;

    }


    

}