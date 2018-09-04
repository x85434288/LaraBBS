<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Image;
use App\Http\Requests\Api\ImageRequest;
use App\Handlers\ImageUploadHandler;
use App\Transformers\ImageTransformer;
use Auth;


class ImagesController extends Controller
{
    //


    public function store(ImageRequest $request, Image $image, ImageUploadHandler $imageUploadHandler)
    {

        //判断上传图片类型
        $max_width=($request->type == 'avatar'? 366:1024);

        //获取上传用户信息
        $user = Auth::guard('api')->user();

        //上传图片
        $file = $imageUploadHandler->save($request->image,str_plural($request->type),$user->id,$max_width);

        $image->user_id = $user->id;
        $image->type  = $request->type;
        $image->path  =$file['path'];
        //保存在数据库中
        $image->save();

//        $image = Image::create([
//
//            'user_id' =>$user->id,
//            'type'  => $request->type,
//            'path'  => $file['path'],
//
//        ]);

        //返回数据
        return $this->response->item($image,new ImageTransformer())->setStatusCode(201);

    }
}
