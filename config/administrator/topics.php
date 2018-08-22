<?php

use App\Models\Topic;


return [

    'title' => '话题管理',

    'single' => '话题',

    'model' => Topic::class,

    'columns' => [

        'id',
        'title'=>[

            'title' => '标题',
            'sortable' => false,
            'output' => function ($value, $model) {
                return '<div style="max-width:260px">'.model_link($value,$model).'</div>';
            },
        ],
        'user'=>[

            'title' => '作者',
            'sortable' => false,
            'output' => function($value, $model){

                $avatar = $model->user->avatar;
                $value = empty($avatar) ? 'N/A' : '<img src="'.$avatar.'" style=" width:22px;height:22px">'.$model->user->name;
                return model_link($value, $model->user);
            }

        ],
        'category'=>[

            'title' => '分类',
            'sortable' => false,
            'output' =>function($value, $model){

                return model_link($model->category->name, $model->category);

            }
        ],

        'created_at'=>[

            'title'=>'添加时间',
            'sortable' => false

        ],

        'reply_count'=>[

            'title' => '评论数'

        ],

        'operation' => [
            'title'  => '管理',
            'sortable' => false,
        ],

    ],

    'edit_fields' => [

        'title' => [
            'title' => '标题',
        ],

        'user' => [

            'title'  =>'用户',
            'type'   =>'relationship',
            'name_field' =>'name',

            //自动补全 对于大数据量的对应关系，推荐开启自动补全
            //可防止一次性加载对系统造成负担

            'autocomplete' => true,

            //自动补全搜索字段
            'search_fields' => ["CONCAT(id, ' ', name)"],

            //自动补全排序

            'options_sort_field' =>'id',

        ],

        'category' => [
            'title'              => '分类',
            'type'               => 'relationship',
            'name_field'         => 'name',
            'search_fields'      => ["CONCAT(id, ' ', name)"],
            'options_sort_field' => 'id',
        ],
        'reply_count' => [
            'title'    => '评论',
        ],
        'view_count' => [
            'title'    => '查看',
        ],
    ],

    'filters' => [

        'id' => [

            // 过滤表单条目显示名称
            'title' => '话题 ID',
        ],

        'user' => [
            'title'              => '用户',
            'type'               => 'relationship',
            'name_field'         => 'name',
            'autocomplete'       => true,
            'search_fields'      => array("CONCAT(id, ' ', name)"),
            'options_sort_field' => 'id',
        ],
        'category' => [
            'title'              => '分类',
            'type'               => 'relationship',
            'name_field'         => 'name',
            'search_fields'      => array("CONCAT(id, ' ', name)"),
            'options_sort_field' => 'id',
        ],

    ],

    'rules'=>[

        'title'=>'required',

    ],

    'messages'=>[

        'title.required'=>'请填写标题'

    ]


];