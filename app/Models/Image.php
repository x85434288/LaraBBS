<?php

namespace App\Models;

use App\Models\User;

//use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    //允许修改的字段
    protected $fillable = ['type', 'path'];


    //与用户表进行关联
    public function user()
    {

        $this->belongsTo(User::class);

    }


}
