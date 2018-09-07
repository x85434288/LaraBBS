<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Link;
use App\Transformers\LinkTransformer;

class LinksController extends Controller
{
    //
    public function index(Link $link)
    {

        $links = $link->getAllCache();

        return $this->response->collection($links, new LinkTransformer());

        //return $this->errorResponse(403,'不能查询到资源推荐',1003);

    }

}
