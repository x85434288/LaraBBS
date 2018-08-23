<?php
namespace App\Models\Traits;

use App\Models\Topic;
use App\Models\Reply;
use App\Models\User;
use Carbon\Carbon;
use Cache;
use DB;


trait ActiveUserHelper
{

    protected $topic_weight = 4;      //话题权重
    protected $reply_weight = 1;      //回复权重
    protected $pass_days = 15;         //多少天发布的内容
    protected $user_number = 6;       //活跃人数

    protected $users = [];              //存放排名数据

    // 缓存相关配置
    protected $cache_key = 'larabbs_active_users';
    protected $cache_expire_in_minutes = 65;


    //计算数据 返回结果s
    public function getActiveUsers()
    {

        // 尝试从缓存中取出 cache_key 对应的数据。如果能取到，便直接返回数据。
        // 否则运行匿名函数中的代码来取出活跃用户数据，返回的同时做了缓存。
        $activeUserCache = Cache::remember($this->cache_key, $this->cache_expire_in_minutes, function(){

            return $this->calculatescore();

        });

        return $activeUserCache;

    }



    //计算并缓存 计划任务调用
    public function calculateAndCacheActiveUser()
    {

        //获得计算的结果
        $result = $this->calculatescore();

        //缓存数据
        Cache::put($this->cache_key, $result, $this->cache_expire_in_minutes);
    }



    //计算发布话题和回复话题的分数
    public function calculateScore()
    {

        $topic_user = Topic::query()->select(DB::raw('user_id,count(1) as topic_count'))
                               ->where('created_at','>=',Carbon::now()->subDays($this->pass_days))
                               ->groupBy('user_id')
                               ->get();

        foreach($topic_user as $value){

            $this->users[$value->user_id]['score'] = $value->topic_count*$this->topic_weight;

        }

        $reply_user = Reply::query()->select(DB::raw('user_id,count(1) as reply_count'))
            ->where('created_at','>=',Carbon::now()->subDays($this->pass_days))
            ->groupBy('user_id')
            ->get();

        foreach($reply_user as $value){

            if(isset($this->users[$value->user_id])){

                $this->users[$value->user_id]['score'] += $value->reply_count*$this->reply_weight;

            }else{

                $this->users[$value->user_id]['score'] = $value->reply_count*$this->reply_weight;
            }

        }



        // 数组按照得分排序
        $users = array_sort($this->users, function($user){

            return $user['score'];

        });

        // 我们需要的是倒序，高分靠前，第二个参数为保持数组的 KEY 不变
        $users = array_reverse($users, true);

        //只获取我们想要的数量

        $users = array_slice($users,0,$this->user_number,true);

        // 新建一个空集合
        $active_users = collect();

        foreach ($users as $user_id => $user) {
            // 找寻下是否可以找到用户
            $user = User::find($user_id);

            // 如果数据库里有该用户的话
            if ($user) {

                // 将此用户实体放入集合的末尾
                $active_users->push($user);
            }
        }

        return $active_users;


    }




}