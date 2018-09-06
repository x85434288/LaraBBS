<?php

namespace App\Http\Controllers\Api;

use App\Models\Reply;
use App\Models\Topic;
use App\Models\User;
use App\Transformers\ReplyTransformer;
use Illuminate\Http\Request;
use App\Http\Requests\Api\ReplyRequest;
//use League\OAuth1\Client\Server\User;

class RepliesController extends Controller
{
    //

    public function store(Reply $reply, ReplyRequest $request, Topic $topic)
    {
        //获取用户的实例等于  Auth::guard('api')->user()
        $user = $this->user();

        $reply->content = $request->content;
        $reply->user_id = $user->id;
        $reply->topic_id = $topic->id;
        $reply->save();

        return $this->response->item($reply,new ReplyTransformer())->setStatusCode(201);

    }


    public function destroy(Topic $topic, Reply $reply)
    {

        //判断删除的回复是否属于某一话题
        if($reply->topic_id != $topic->id){
            return $this->response->errorBadRequest();
        }

        //判断用户是否有删除权限
        $this->authorize('destroy',$reply);
        //删除回复
        $reply->delete();

        return $this->response->noContent();

    }

    //某个话题的回复列表
    public function topicReplyIndex(Topic $topic)
    {

        $replies = $topic->replies()->paginate(20);

        return $this->response->paginator($replies, new ReplyTransformer());

    }


    //某个用户的回复列表
    public function userReplyIndex(User $user)
    {

        $replies = $user->replies()->paginate(20);

        return $this->response->paginator($replies, new ReplyTransformer());

    }






}
