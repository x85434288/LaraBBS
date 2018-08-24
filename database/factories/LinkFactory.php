<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Link::class, function (Faker $faker) {

    $sentence = $faker->sentence();  //生成随机字符串
    $updated_at = $faker->dateTimeThisMonth();
    $created_at = $faker->dateTimeThisMonth($updated_at);

    return [

        'title' => $sentence,
        'link'  => 'http://www.baidu.com',
        'created_at' => $created_at,
        'updated_at' => $updated_at,

        //
    ];
});
