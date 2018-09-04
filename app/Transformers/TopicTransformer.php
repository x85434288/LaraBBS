<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/4
 * Time: 10:43
 */

namespace App\Transformers;

use App\Models\Topic;
use League\Fractal\TransformerAbstract;

class TopicTransformer extends TransformerAbstract{

    public function transform(Topic $topic)
    {

        return [

            'id' => $topic->id,
            'title' => $topic->title,
            'body' => $topic->body,
            'user_id' => (int) $topic->user_id,
            'category_id' => (int) $topic->category_id,
            'reply_count' => (int) $topic->reply_count,
            'view_count' =>  (int) $topic->view_count,
            'last_reply_user_id' => (int) $topic->last_reply_user_id,
            'order' => $topic->order,
            'excerpt' => $topic->excerpt,
            'slug'  => $topic->slug,
            'created_at' => $topic->created_at->toDateTimeString(),
            'updated_at' => $topic->updated_at->toDateTimeString(),
        ];

    }


}