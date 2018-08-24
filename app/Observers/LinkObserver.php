<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/24
 * Time: 11:07
 */

namespace App\Observers;
use App\Models\Link;
use Cache;


class LinkObserver
{

    public function saved(Link $link)
    {

        //$result = $link->all();

        //Cache::put($result->cache_key, $result, $result->cache_expire_in_minutes);

        Cache::forget($link->cache_key);

    }

}