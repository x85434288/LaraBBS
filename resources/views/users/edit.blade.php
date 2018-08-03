@extends('layouts.app')
@section('title','编辑'.$user->name)
@section('content')

    <div class="container">

        <div class="panel panel-default col-md-10 col-md-offset-1">
            <div class="panel-heading"><h4>编辑</h4></div>
            @include('common.error')
            <div class="panel-body">
                <form action="{{ route('users.update',$user->id) }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field("PUT") }}

                    <div class="form-group">
                        <label class="name-field">用户名：</label>
                        <input class="form-control" type="text" id="name-field" name="name" value="{{ old('name',$user->name) }}">
                    </div>

                    <div class="email-group">
                        <label class="name-field">邮箱：</label>
                        <input class="form-control" type="text" id="email-field" name="email" value="{{ old('email',$user->email) }}">
                    </div>

                    <div class="form-group">
                        <label class="introduction-field">简介：</label>
                        <textarea rows="3" class="form-control" name="introduction" id="introduction-field">{{ old('introduction',$user->introduction) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="avatar-label">用户头像</label>
                        <input type="file" name="avatar">
                        @if($user->avatar)
                            <br>
                            <img class="thumbnail img-responsive" src="{{ $user->avatar }}" width="200">
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">提交</button>

                </form>

            </div>
        </div>

    </div>

@stop