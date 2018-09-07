<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Transformers\PermissionTransformer;

class PermissionsController extends Controller
{

    //显示登录用户权限
    public function show()
    {

        $permissions = $this->user()->getAllPermissions();
        return $this->response->collection($permissions, new PermissionTransformer());

    }

}
