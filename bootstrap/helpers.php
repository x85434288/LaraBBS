<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/1
 * Time: 15:26
 */


function route_class(){

    return str_replace('.', ',', Route::currentRouteName());

}