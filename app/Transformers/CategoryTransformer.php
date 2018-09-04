<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/4
 * Time: 10:01
 */
namespace App\Transformers;

use App\Models\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract{

    public function transform(Category $category)
    {

        return [
            'id' => $category->id,
            'name' => $category->name,
            'description' => $category->description,
        ];


    }


}