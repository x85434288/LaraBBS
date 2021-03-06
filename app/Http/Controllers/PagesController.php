<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Models\Traits\ActiveUserHelper;


class PagesController extends Controller
{
    //

    //use ActiveUserHelper;

    public function root()
    {


        //dd($this->calculatescore());

        return view('pages.root');
    }


    public function permissionDenied()
    {

        //$closure = config('administrator.permission');

        //$permission = ($closure instanceof \Colsure) ? $closure() : false ;

        $permission = config('administrator.permission')();

        // 如果当前用户有权限访问后台，直接跳转访问
        if ($permission) {
        return redirect(url(config('administrator.uri')), 302);
    }
        // 否则使用视图

        return view('pages.permission-denied');
        
    }
    
}
