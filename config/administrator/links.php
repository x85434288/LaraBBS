<?php
use App\Models\Link;


return [

    'title' => '资源管理',

    'single' => '资源',

    'model' => Link::class,

    //访问控制

    'permission' => function(){

      return Auth::user()->hasRole('Founder');

    },

    'columns' => [

        'id',
        'title'=>[

            'title' => '标题',
            'sortable' => false,
            'output' => function ($value, $model) {
                return '<div style="max-width:260px">'.$value.'</div>';
            },
        ],
        'link'=>[

            'title' => '链接',
            'sortable' => false,
            'output' => function($value, $model){
                return '<a href="'.$value.'" target="_blank">'.$value.'</a>';
            }

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

        'link' => [

            'title'  =>'链接',

        ],

    ],

    'filters' => [

        'title' => [

            // 过滤表单条目显示名称
            'title' => '标题',
        ],


        'link' => [

            // 过滤表单条目显示名称
            'title' => '链接',
        ],

    ],

    'rules'=>[

        'title'=>'required',
        'link' => 'required'

    ],

    'messages'=>[

        'title.required'=>'请填写标题',
        'link.required' => '请填写链接'

    ]

];