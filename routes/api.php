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

        //获取话题列表
        $api->get('topics','TopicsController@index')->name('api.topics.index');

        //获取某个用户发布话题列表
        $api->get('users/{user}/topics','UsersController@userIndex')->name('api.users.topics.index');

        //获取某个话题详情
        $api->get('topics/{topic}','TopicsController@show')->name('api.topics.show');

        //某个话题的回复列表
        $api->get('topics/{topic}/replies', 'RepliesController@topicReplyIndex')
            ->name('api.topics.replies.topicReplyIndex');


        //某个用户的回复列表
        $api->get('users/{user}/replies','RepliesController@userReplyIndex')
            ->name('api.users.replies.userReplyIndex');

        //获取活跃用户
        $api->get('users/active','UsersController@active')->name('api.users.active');

        //获取推荐资源
        $api->get('links','LinksController@index')->name('api.links.index');



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

            //删除话题
            $api->delete('topics/{topic}','TopicsController@destroy')
                ->name('api.topics.destroy');

            // 发布回复
            $api->post('topics/{topic}/replies', 'RepliesController@store')
                ->name('api.topics.replies.store');

            //删除回复
            $api->delete('topics/{topic}/replies/{reply}','RepliesController@destroy')
                ->name('api.topics.replies.destroy');

            //用户通知列表
            $api->get('user/notifications','NotificationsController@index')
                ->name('api.user.notification.index');

            //用户未读回复
            $api->get('user/notifications/stats','NotificationsController@stats')
                ->name('api.user.notification.stats');

            //清除未读消息
            $api->patch('user/read/notifications','NotificationsController@read')
                ->name('api.user.notifications.read');

            //当前登录用户权限
            $api->get('user/permissions','PermissionsController@show')->name('api.user.permissions.show');


        });


    });

});
