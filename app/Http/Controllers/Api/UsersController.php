<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Image;
use Illuminate\Http\Request;
use App\Http\Requests\Api\UsersRequest;
use Cache;
use Auth;
use App\Transformers\UserTransformer;
use App\Transformers\TopicTransformer;

class UsersController extends Controller
{
    //
    public function store(UsersRequest $request)
    {
        //从缓存中获取保存的验证码信息
        $code = Cache::get($request->verification_key);
        if(!$code){
            return $this->response->error('验证码已失效',422);
        }

        //比对验证码是否与缓存中一致时，使用了 hash_equals 方法
        //hash_equal函数 防止时序攻击
        if(!hash_equals($code['code'],$request->verification_code)){

            return $this->response->errorUnauthorized('验证码错误');
        }

        $user = User::create(
            [
                'name' => $request->name,
                'phone' => $code['phone'],
                'password' => bcrypt($request->password),
            ]
        );

        // 清除验证码缓存
        Cache::forget($request->verification_key);

        //return $this->response->created();
        return $this->response->item($user, new UserTransformer())->setMeta([

            'access_token' => Auth::guard('api')->fromUser($user),
            'expired_at' => Auth::guard('api')->factory()->gatTTL()*60,
            'type' => 'Bearer',


        ])->setStatusCode(201);


    }

    //返回个人信息
    public function me()
    {

        return $this->response->item($this->user(), new UserTransformer())->setStatusCode(201);

//        return $this->response->item($this->user(), new UserTransformer())->setMeta([
//
//            'access_token' => Auth::guard('api')->fromUser($this->user()),
//            'expired_at' => Auth::guard('api')->factory()->getTTL()*60,
//            'type' => 'Bearer',
//
//        ])->setStatusCode(201);
    }


    //更新个人信息
    public function update(UsersRequest $request)
    {

        //获取上传用户信息
        $user = Auth::guard('api')->user();

        //获取用户提交参数
        $attributes = $request->only('name','email','introduction');

        if($request->avatar_image_id){

            $image = Image::find($request->avatar_image_id);
            $attributes['avatar'] = $image->path;

        }

        $user->update($attributes);

        return $this->response->item($user, new UserTransformer());
        //print_r($attributes);

    }

    //个人发布话题列表

    public function userIndex(User $user, Request $request)
    {

        $topics = $user->topics()->recent()->paginate(20);

        return $this->response->paginator($topics, new TopicTransformer());

    }
    
}
