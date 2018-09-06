<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/5
 * Time: 16:26
 */

namespace App\Transformers;

use App\Models\Reply;
use League\Fractal\TransformerAbstract;


class ReplyTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'user','topic'
    ];


    public function transform(Reply $reply)
    {

        return [

            'id' => $reply->id,
            'user_id' => $reply->user_id,
            'topic_id' => $reply->topic_id,
            'content'  => $reply->content,
            'created_at' => $reply->created_at->toDateTimeString(),
            'updated_at' => $reply->updated_at->toDateTimeString(),

        ];
    }


    public function includeUser(Reply $reply)
    {

        $users = $reply->user;
        return $this->item($users, new UserTransformer());

    }


    public function includeTopic(Reply $reply)
    {

        $topics = $reply->topic;
        return $this->item($topics, new TopicTransformer());

    }

}