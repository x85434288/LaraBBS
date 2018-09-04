<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Transformers\CategoryTransformer;

class CategoriesController extends Controller
{

    //显示话题分类信息
    public function index(Category $category)
    {

        $categories = $category->all();

        //分类数据是集合，所以我们使用 $this->response->collection 返回数据
        return $this->response->collection($categories, new CategoryTransformer());
        
    }


    
}
