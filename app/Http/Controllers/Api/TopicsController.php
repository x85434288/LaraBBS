<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Topic;
use App\Http\Requests\Api\TopicRequest;
use Auth;
USE App\Transformers\TopicTransformer;

class TopicsController extends Controller
{

    //添加话题
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


    //修改话题
    public function update(Topic $topic, TopicRequest $request)
    {

        $this->authorize('update', $topic);

        $topic->update($request->all());

        return $this->response->item($topic, new TopicTransformer())->setStatusCode(201);

    }

    //删除话题
    public function destroy(Topic $topic)
    {

        $this->authorize('destroy',$topic);

        $topic->delete();

        return $this->response->noContent();

    }

    //话题列表
    public function index(Topic $topic, Request $request)
    {

        $query = $topic->query();

        if($request->category_id){

            $query->where('category_id',$request->category_id);
           // $appends['category_id'] = $request->category_id;

        }

        switch($request->order){

            case 'recent':
                $query->recent();
                //$appends['order'] = $request->order;
                break;

            default :
                $query->recentReplied();
                break;
        }


        $topics = $query->paginate(10);

//        if(count($appends)>0){
//
//            $topics->appends($appends)->links();
//        }

        return $this->response->paginator($topics, new TopicTransformer());

    }


    //话题详情
    public function show(Topic $topic)
    {

        return $this->response->item($topic,new TopicTransformer());

    }

}
