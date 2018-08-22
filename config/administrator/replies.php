<?php

use App\Models\Reply;

return [

    'title'=>'回复管理',

    'single' => '回复',

    'model' => Reply::class,

    'columns' =>[

        'id',
        'content'=>[

            'title' => '回复',
            'sortable' => false,
            'output' => function($value ,$model){

                return '<div style="max-width:220px"><a href="'.$model->topic->link(['#reply'.$model->id]).'" target="_blank">'.e($value).'</a></div>';
            }
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

        'topic'=>[

            'title' => '话题',
            'sortable' => false,
            'output' => function($value, $model){

                return  model_link($model->topic->title,$model->topic);

            }

        ],

        'operation' => [
            'title'  => '管理',
            'sortable' => false,
        ],
    ],

    'edit_fields'=>[

        'user' => [
            'title' =>'用户',
            'type' => 'relationship',
            'name_field' => 'name',
            'autocomplete' => true,
            'search_fields' => array("CONCAT(id, ' ', name)"),
            'options_sort_field' => 'id',

        ],

        'topic' => [
            'title' =>'话题',
            'type' => 'relationship',
            'name_field' => 'title',
            'autocomplete' => true,
            'search_fields' => array("CONCAT(id, ' ', title)"),
            'options_sort_field' => 'id',

        ],

        'content' => [

            'title' => '回复',
            'type' => 'textarea'

        ],

    ],

    'filters'=>[
        'user' => [
            'title'              => '用户',
            'type'               => 'relationship',
            'name_field'         => 'name',
            'autocomplete'       => true,
            'search_fields'      => array("CONCAT(id, ' ', name)"),
            'options_sort_field' => 'id',
        ],

        'topic' => [
            'title'              => '话题',
            'type'               => 'relationship',
            'name_field'         => 'title',
            'autocomplete'       => true,
            'search_fields'      => array("CONCAT(id, ' ', title)"),
            'options_sort_field' => 'id',
        ],

    ]


];