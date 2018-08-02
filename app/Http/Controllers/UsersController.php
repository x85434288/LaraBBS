<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;

class UsersController extends Controller
{
    //
    //展示个人页面
    public function show(User $user)
    {

        return view('users.show',compact('user'));

    }

    //编辑个人资料页面
    public function edit(User $user)
    {

        return view('users.edit',compact('user'));

    }

    //保存个人资料页面

    public function update(UserRequest $request, User $user)
    {
        $user->update($request->all());
        return redirect()->route('users.show',$user->id)->with('success','个人资料更新成功');
    }


}
