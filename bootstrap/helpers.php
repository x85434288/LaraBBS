<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/1
 * Time: 15:26
 */


function route_class(){

    return str_replace('.', '-', Route::currentRouteName());

}

function make_excerpt($value ,$length=200){

    $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
    return str_limit($excerpt, $length);

}


function model_admin_link($title, $model){

    return model_link($title, $model, 'admin');

}


function model_link($title, $model, $prefix=''){

    //获取模型的复数蛇形命名
    $model_name = model_plural_name($model);
    //初始化前缀
    $prefix = $prefix ? "/$prefix/" : "/";
    //拼接url
    $url = config('app.url').$prefix.$model_name.'/'.$model->id;

    // 拼接 HTML A 标签，并返回
    return '<a href="' . $url . '" target="_blank">' . $title . '</a>';

}


function model_plural_name($model){

    // 从实体中获取完整类名，例如：App\Models\User
    $full_class_name = get_class($model);
    //获取基础类名 例如：App\Models\User 将会获取 User
    $class_name = class_basename($full_class_name);
    // 蛇形命名，例如：传参 `User`  会得到 `user`, `FooBar` 会得到 `foo_bar`
    $snack_case_name = snake_case($class_name);
    // 获取子串的复数形式，例如：传参 `user` 会得到 `users`
    return str_plural($snack_case_name);



}

