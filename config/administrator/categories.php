<?php

use App\Models\Category;
use Spatie\Permission\Models\Permission;

return[
    //页面标题
    'title' => '分类管理',

    'single' => '分类',

    'model' => Category::class,

    //只有用户管理权限才能查看此页面
    'permission' => function(){

        return Auth::user()->can('manage_users');
    },

    //只有站长才能删除此分类
    'action_permissions'=>[

        'delete'=>function(){

            return Auth::user()->hasRole('Founder');

        }

    ],

    'columns' =>[

        'id',
        'name' => [
            'title' => '分类',
            'sortable' => false,
            'output' => function ($name, $model) {
                return '<a href="/topics/'.$model->id.'" target=_blank>'.$name.'</a>';
            },
        ],
        'description' => [
            'title' => '简介',
            'sortable' => false,
        ],
        'operation' => [
            'title'  => '管理',
            'sortable' => false,
        ],

    ],

    'edit_fields' => [

        'name' => [
            'title' => '分类',
        ],
        'description' => [
            'title' => '简介',
        ],
    ],

    'filters' => [

        'id' => [

            // 过滤表单条目显示名称
            'title' => '分类 ID',
        ],

        'name' => [
            'title' => '分类名',
        ],
        'description' => [
            'title' => '描述',
        ],

    ],

    //字段提交验证规则
    'rules' => [

        'name' => 'required|min:1|unique:categories'

    ],

    //验证规则返回信息
    'messages' => [

        'name.unique'   => '分类名在数据库里有重复，请选用其他名称。',
        'name.required' => '请确保名字至少一个字符以上',

    ]

];