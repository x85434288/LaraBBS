<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\Api\CaptchaRequest;
use Gregwar\Captcha\CaptchaBuilder;
use Cache;

class CaptchasController extends Controller
{
    //

    public function store(CaptchaRequest $request, CaptchaBuilder $captchaBuilder)
    {

        $key = 'captcha-'.str_random(15);
        $phone = $request->phone;
        $expired_at = now()->addMinutes(2); //设定过期时间为2分钟
        $captcha = $captchaBuilder->build();
        Cache::put($key,['phone'=>$phone,'code'=>$captcha->getPhrase()],$expired_at);

        $picture = $captcha->inline();   //生成图片64位编码

        $result = [
            'captcha_key'=>$key,
            'picture'=>$picture,
            'expired_at'=>$expired_at->toDateTimeString(),
            //'code'  => $captcha->getPhrase(),
        ];

        return $this->response->array($result)->setStatusCode(201);

    }
    
}
