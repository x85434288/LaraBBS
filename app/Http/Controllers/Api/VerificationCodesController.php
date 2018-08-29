<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Cache;
use Overtrue\EasySms\EasySms;
use App\Http\Requests\Api\VerificationCodeRequest;

class VerificationCodesController extends Controller
{
    //

    public function store(VerificationCodeRequest $request, EasySms $easySms)
    {

        $phone = $request->phone; //验证phone格式
        $code = str_pad(random_int(1,9999),0,4,STR_PAD_LEFT);  // 生成4位随机数，左侧补0
        if(!app()->environment('production')){
            $code = '1234';
        }else{
            try {
                $result = $easySms->send($phone, [
                    'content'  =>  "您的验证码是{$code}。如非本人操作，请忽略本短信"
                ]);
            } catch (\Overtrue\EasySms\Exceptions\NoGatewayAvailableException $exception) {
                $message = $exception->getException('yunpian')->getMessage();
                return $this->response->errorInternal($message ?? '短信发送异常');
            }
        }

        $key = 'VerificationCode_'.str_random(15); //生成验证码key
        $expiredAt = now()->addMinutes(10);

        //保存在缓存中
        Cache::put($key,['phone'=>$phone,'code'=>$code],$expiredAt);


        //返回给客户端
        return $this->response->array(
            [
                'key' => $key,
                'expired_at' => $expiredAt->toDateTimeString(),
            ]
        )->setStatusCode(201);


        //return $this->response->array(['test_message'=>'test api']);

    }

}
