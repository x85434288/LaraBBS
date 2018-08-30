<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Api\SocialsRequest;


class AuthorizationsController extends Controller
{
    //

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

        return $this->response->array([
            'authid' => $user->id,
        ]);



        //return $this->response->array(['token'=>$type]);


    }

}


