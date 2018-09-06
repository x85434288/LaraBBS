<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Transformers\NotificationTransformer;


class NotificationsController extends Controller
{

    //通知列表
    public function index()
    {

        $replies = $this->user()->notifications()->paginate(20);
        return $this->response->paginator($replies, new  NotificationTransformer());

    }


    //话题回复数量
    public function stats()
    {

        $stats = $this->user->notification_count;

        return $this->response->array(['notification_count'=>$stats]);

    }





}
