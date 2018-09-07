<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/7
 * Time: 16:55
 */

namespace Tests\Traits;

use App\Models\User;

trait ActingJWTUser
{

    public function JWTActingAs(User $user)
    {

        $token = \Auth::guard('api')->fromUser($user);
        $this->withHeaders(['Authorization' => 'Bearer '.$token]);

        return $this;
        
    }


}