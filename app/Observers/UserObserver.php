<?php

namespace App\Observers;

use App\Models\User;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class UserObserver
{
    public function creating(User $user)
    {
        //


    }

    public function updating(User $user)
    {
        //
    }

    public function saving(User $user)
    {
        //当头像为空时用默认头像代替
        if(empty($user->avatar)){
            $user->avatar = "https://fsdhubcdn.phphub.org/uploads/images/201710/30/1/TrJS40Ey5k.png";
        }


    }
}