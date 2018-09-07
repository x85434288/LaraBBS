<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Api\SocialsRequest;
use App\Http\Requests\Api\AuthorizationRequest;
use Illuminate\Support\Facades\Auth;


class AuthorizationsController extends Controller
{
    //

    //第三方登录
    public function SocialsStore($type, SocialsRequest $request)
    {

        //判断登录类型
        if(!in_array($type, ['weixin'])){
            return $this->response->errorBadRequest();
        }

        $driver = \Socialite::driver($type);

        try{

            if($code = $request->code){

                $response = $driver->getAccessTokenResponse($code);
                $access_token = array_get($response,'access_token');

            }else{

                $access_token = $request->access_token;

                if($type=='weixin'){

                    $driver->setOpenId($request->openid);

                }


            }

            $oauthUser = $driver->userFromToken($access_token);

        }
        catch(\ErrorException $e){

            return $this->response->error('获取参数错误',422);

        }


        switch($type){

            case 'weixin' :

                $unionid = $oauthUser->offsetExists('unionid') ? $oauthUser->offsetGet('unionid') : null;
                if($unionid){

                    $user = User::where('weixin_unionid',$unionid)->first();
                }else{

                    $user = User::where('weixin_openid',$oauthUser->getId())->first();

                }

            if(!$user){

                $user = User::create([
                    'name' => $oauthUser->getNickname(),
                    'avatar' => $oauthUser->getAvatar(),
                    'weixin_openid'  => $oauthUser->getId(),
                    'weixin_unionid' => $unionid,
                ]);
            }

            break;

        }

        $token = Auth::guard('api')->fromUser($user);

        return $this->responseWithToken($token)->setStatusCode(201);

        //return $this->response->array(['token'=>$type]);


    }


    //登录
    public function store(AuthorizationRequest $request)
    {


        $username = $request->username;
        //验证是否是邮箱 或者 手机号
        filter_var($username,FILTER_VALIDATE_EMAIL) ? $validate['email'] = $username : $validate['phone'] = $username;

        $validate['password'] = $request->password;

        //验证密码
        $token = Auth::guard('api')->attempt($validate);

        if(!$token){

            //return $this->response->errorUnauthorized('用户名密码错误');

            return $this->response->errorUnauthorized(trans('auth.failed'));
        }

        return $this->responseWithToken($token)->setStatusCode(201);

    }

    //更新登录凭据
    public function update()
    {

        $token = Auth::guard('api')->refresh();
        return $this->responseWithToken($token);
    }

    //删除登录凭据
    public function destroy()
    {

        Auth::guard('api')->logout();
        return $this->response->noContent();

    }

    //返回登录凭据
    public function responseWithToken($token)
    {

        $array = [

            'access_token'  => $token,
            'token_type'  =>'Bearer',
            'expires_at'  =>Auth::guard('api')->factory()->getTTL()*60,

        ];

        return $this->response->array($array);

    }




}


