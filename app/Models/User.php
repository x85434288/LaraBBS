<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;

class User extends Authenticatable
{
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
        'name', 'email', 'password','avatar','introduction'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


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

}
