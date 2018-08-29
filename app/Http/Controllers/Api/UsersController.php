<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\Api\UsersRequest;
use App\Models\User;
use Cache;

class UsersController extends Controller
{
    //
    public function store(UsersRequest $request)
    {
        $code = Cache::get($request->verification_key);
        if(!$code){
            return $this->response->error('验证码已失效',422);
        }

        if(!hash_equals($code['code'],$request->verification_code)){

            return $this->response->errorUnauthorized('验证码错误');
        }

        User::create(
            [
                'name' => $request->name,
                'phone' => $code['phone'],
                'password' => bcrypt($request->password),
            ]
        );

        Cache::forget($request->verification_key);

        return $this->response->created();


        
    }
    
}
