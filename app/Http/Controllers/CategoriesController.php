<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Topic;

class CategoriesController extends Controller
{
    //

    public function show(Category $category, Request $request, Topic $topic, User $user, Link $link)
    {

        $active_users = $user->getActiveUsers();
        $links = $link->getAllCache();
        //$topics =   Topic::where('category_id',$category->id)->paginate();
        $topics =   $topic->withOrder($request->order)->where('category_id',$category->id)->paginate();
        return view('topics.index',compact('topics','category','active_users','links'));

    }

}
