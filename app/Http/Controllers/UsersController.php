<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Handlers\ImageUploadHandler;

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

    public function update(UserRequest $request, ImageUploadHandler $imageUploadHandler, User $user)
    {
        //dd($request->avatar->getClientOriginalExtension());
        $data = $request->all();
        $file = $request->avatar;
        if($file){
            $result = $imageUploadHandler->save($file, 'avatars', $user->id, 360);
            if($result){
                $data['avatar'] = $result['path'];
            }else{
                $data['avatar'] = '';
            }
        }

        $user->update($data);
        return redirect()->route('users.show',$user->id)->with('success','个人资料更新成功');
    }


}
