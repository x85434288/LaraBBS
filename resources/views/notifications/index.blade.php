@extends('layouts.app')
@section('title','通知')
@section('content')

    <div class="container">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-body">

                    <h3 class="text-center">
                        <span class="glyphicon glyphicon-bell">我的通知</span>
                    </h3>
                    <hr>

                    @if($notifications->count())
                        <div class="notification-list">
                            @foreach($notifications as $notification)
                                @include('notifications.types._'.snake_case(class_basename($notification->type)))
                            @endforeach

                            {!! $notifications->render() !!}
                        </div>
                    @else
                        <span>暂无消息</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

@stop