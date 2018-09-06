<?php

namespace App\Http\Controllers\Api;

use App\Models\Reply;
use App\Models\Topic;
use App\Transformers\ReplyTransformer;
use Illuminate\Http\Request;
use App\Http\Requests\Api\ReplyRequest;

class RepliesController extends Controller
{
    //

    public function store(Reply $reply, ReplyRequest $request, Topic $topic)
    {

        $user = $this->user();
        $reply->content = $request->content;
        $reply->user_id = $user->id;
        $reply->topic_id = $topic->id;
        $reply->save();

        return $this->response->item($reply,new ReplyTransformer())->setStatusCode(201);

    }

}
