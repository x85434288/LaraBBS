<?php

use Illuminate\Database\Seeder;
use App\Models\Topic;
use App\Models\User;
use App\Models\Category;

class TopicsTableSeeder extends Seeder
{
    public function run()
    {

        //获取所有用户id
        $user_ids = User::all()->pluck('id')->toArray();

        //获取所有分类id
        $category_ids = Category::all()->pluck('id')->toArray();

        //获取faker实例
        $faker = app(Faker\Generator::class);

        $topics = factory(Topic::class)->times(50)->make()->each(function ($topic, $index) use($user_ids, $category_ids, $faker) {

            $topic->user_id = $faker->randomElement($user_ids);
            $topic->category_id = $faker->randomElement($category_ids);

        });

        Topic::insert($topics->toArray());
    }

}

