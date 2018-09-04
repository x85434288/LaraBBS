<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Topic;
use App\Http\Requests\Api\TopicRequest;
use Auth;
USE App\Transformers\TopicTransformer;

class TopicsController extends Controller
{
    //

    public function store(Topic $topic, TopicRequest $request)
    {

//        $attributes = $request->only('title','body','category_id');
//        $user = Auth::guard('api')->user();
//        $attributes['user_id'] = $user->id;
        $topic->fill($request->all());
        $user = Auth::guard('api')->user();
        $topic->user_id = $user->id;
        $topic->save();

        return $this->response->item($topic, new TopicTransformer())->setStatusCode(201);

    }


    public function update(Topic $topic, TopicRequest $request)
    {

        $this->authorize('update', $topic);

        $topic->update($request->all());

        return $this->response->item($topic, new TopicTransformer())->setStatusCode(201);

    }

}
