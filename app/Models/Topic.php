<?php

namespace App\Models;


//use Illuminate\Foundation\Auth\User;

class Topic extends Model
{
    protected $fillable = ['title', 'body', 'category_id', 'excerpt', 'slug'];

    public function category()
    {

        return $this->belongsTo(Category::class);

    }

    public function user()
    {

        return $this->belongsTo(User::class);

    }


    //构建最新发布和最后回复功能
    public function scopeWithOrder($query, $order)
    {

        switch($order){

            case 'recent':
                $query->recent();
                break;

            default :
                $query->recentReplied();
                break;
        }

        return $query->with('user','category');

    }


    //最新发布
    public function scopeRecent($query)
    {

        return $query->orderBy('created_at', 'desc');
        
    }


    //最后发布
    public function scopeRecentReplied($query)
    {

        return $query->orderBy('updated_at', 'desc');

    }


    //SEO 路由链接

    public function link($param=[])
    {

        return route('topics.show', array_merge([$this->id,$this->slug],$param));

    }


    
    
    


}
