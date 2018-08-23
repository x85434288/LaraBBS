<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Topic;

class CategoriesController extends Controller
{
    //

    public function show(Category $category, Request $request, Topic $topic, User $user)
    {

        $active_users = $user->getActiveUsers();
        //$topics =   Topic::where('category_id',$category->id)->paginate();
        $topics =   $topic->withOrder($request->order)->where('category_id',$category->id)->paginate();
        return view('topics.index',compact('topics','category','active_users'));

    }

}
