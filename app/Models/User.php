<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;
use Spatie\Permission\Traits\HasRoles;
use Redis;

class User extends Authenticatable implements JWTSubject
{

    use Traits\ActiveUserHelper;
    use Traits\LastActivedAtHelper;
    use HasRoles;
    use Notifiable{

        //重命名 trait Notifiable类中的notify方法为laravelNotify
        //即重写notify方法 详见52行
        notify as protected laravelNotify;

    }
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','avatar','introduction','phone','weixin_openid','weixin_unionid'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getJWTIdentifier()
    {

        return $this->getKey();
        
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    

    public function topics()
    {

        return $this->hasMany(Topic::class);

    }

    public function replies()
    {

        return $this->hasMany(Reply::class);

    }

    public function notify($instance)
    {

        //如果通知的人是当前用户 就不必通知了
        if($this->id == Auth::id()){
            return;
        }
        $this->increment('notification_count');
        $this->laravelNotify($instance);
    }


    //标记已阅读
    public function markAsRead()
    {

        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();

    }

    public function isAuthorOf($model)
    {
        return $this->id == $model->user_id;
    }


    public function setPasswordAttribute($value)
    {

        //如果长度不是60 就代表是后台修改的密码 需要进行加密处理
        if( strlen($value) !=60 ){

            $value = bcrypt($value);

        }

        $this->attributes['password'] = $value;
        
    }


    public function setAvatarAttribute($path)
    {
        // 如果不是 `http` 子串开头，那就是从后台上传的，需要补全 URL
        if ( ! starts_with($path, 'http')) {

            // 拼接完整的 URL
            $path = config('app.url') . "/uploads/images/avatars/$path";
        }

        $this->attributes['avatar'] = $path;
    }


//    public function getUserLastActivedTime()
//    {
//
//        $time = Redis::hGet('larabbs_last_actived_at_2018-08-27','user_1');
//        return new Carbon($time);
//    }

}
