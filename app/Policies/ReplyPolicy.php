<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Reply;

class ReplyPolicy extends Policy
{
    public function update(User $user, Reply $reply)
    {
        // return $reply->user_id == $user->id;
        return true;
    }

    public function destroy(User $user, Reply $reply)
    {

        //帖子的作者 或者回复的人可以删除回复
        return $user->isAuthorOf($reply) || $user->isAuthorOf($reply->topic);

    }
}
