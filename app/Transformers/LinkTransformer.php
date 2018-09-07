<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/7
 * Time: 10:59
 */

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Link;

class LinkTransformer extends TransformerAbstract
{

    public function transform(Link $link)
    {

        return [

            'id' => $link->id,
            'title' => $link->title,
            'link'  => $link->link,
            'created_at' => $link->created_at->toDateTimeString(),
            'updated_at' => $link->updated_at->toDateTimeString(),

        ];

    }

}