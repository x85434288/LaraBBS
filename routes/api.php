<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

$api = app('Dingo\Api\Routing\Router');

$api->version('v1',['namespace'=>'App\Http\Controllers\Api','middleware'=>['serializer:array', 'bindings']],function($api){

    $api->group([

        'middleware'=>'api.throttle',
        'limit' => config('api.rate_limits.sign.limit'),
        'expires' => config('api.rate_limits.sign.expires'),

    ],function($api){

        //游客可以访问的接口
        //验证码
        $api->post('verificationCodes','VerificationCodesController@store')->name('api.verificationCodes.store');
        //用户注册
        $api->post('users','UsersController@store')->name('api.users.store');
        //图形验证码
        $api->post('captchas','CaptchasController@store')->name('api.captchas.store');

        //第三方登录
        $api->post('socials/{social_type}/authorizations','AuthorizationsController@socialsStore')->name('api.socials.authorizations.store');

        //登录
        $api->post('authorizations','AuthorizationsController@store')->name('api.authorizations.store');

        //获取话题分类
        $api->get('categories','CategoriesController@index')->name('api.categories.index');



        //登录后才能访问的接口
        // 需要 token 验证的接口
        $api->group(['middleware' => 'api.auth'], function($api) {

            //刷新token
            $api->put('authorizations/current','AuthorizationsController@update')->name('api.authorizations.current');

            //删除token
            $api->delete('authorizations/current','AuthorizationsController@destroy')->name('api.authorizations.current');

            // 当前登录用户信息
            $api->get('user', 'UsersController@me')
                ->name('api.user.show');

            //上传图片
            $api->post('image','ImagesController@store')
                ->name('api.images.store');

            //编辑个人信息
            $api->patch('user','usersController@update')
                ->name('api.users.update');

            //添加话题
            $api->post('topics','TopicsController@store')->name('api.topics.store');

            //修改话题
            $api->patch('topics/{topic}', 'TopicsController@update')
                ->name('api.topics.update');


        });


    });

});
