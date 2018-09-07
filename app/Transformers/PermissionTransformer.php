<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/7
 * Time: 9:12
 */

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use Spatie\Permission\Models\Permission;

class PermissionTransformer extends TransformerAbstract
{

    public function transform(Permission $permission)
    {

        return [

            'id' => $permission->id,
            'name' => $permission->name,

        ];
        
    }

}