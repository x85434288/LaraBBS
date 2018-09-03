<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Api\UsersRequest;
use Cache;
use Auth;
use App\Transformers\UserTransformer;

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
    
}
