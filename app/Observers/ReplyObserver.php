<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\TopicReplied;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    public function creating(Reply $reply)
    {
        //提交之前处理xss攻击
        $reply->content = clean($reply->content,'user_topic_body');

    }

    public function created(Reply $reply)
    {
        //提交之后回复总数加1
        $topic = $reply->topic;
        $topic->increment('reply_count',1);

        //回复之后通知发帖的用户
        //其他用户回复的才通知
        if(!$reply->user->isAuthorOf($topic)){

            $topic->user->notify(new TopicReplied($reply));

        }




    }

    //删除回复后topic减1
    public function deleted(Reply $reply)
    {

        $reply->topic->decrement('reply_count',1);
        
    }
    
}