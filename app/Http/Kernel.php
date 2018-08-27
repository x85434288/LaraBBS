<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     *
     * 全局中间件，在每次web请求都会调用
     */
    protected $middleware = [
        //检测应用是否进入[维护模式]

        // 见：https://d.laravel-china.org/docs/5.5/configuration#maintenance-mode
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,

        //检测请求的数据是否过大
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,

        //对提交的参数进行 php函数 `trim()` 处理
        \App\Http\Middleware\TrimStrings::class,

        //将提交请求参数中空字符串转换为null
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,

       //修正代理服务器后的服务器参数
        \App\Http\Middleware\TrustProxies::class,
    ];

    /**
     * The application's route middleware groups.
     * 定义路由中间件
     *
     * @var array
     */
    protected $middlewareGroups = [
        //web中间件组，应用于 routes/web.php路由文件
        'web' => [

            //cookie 加密解密
            \App\Http\Middleware\EncryptCookies::class,

           //将 cookie 添加到响应中
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,

            //开启会话
            \Illuminate\Session\Middleware\StartSession::class,

            //认证用户，此中间件以后Auth类才生效
            // 见：https://d.laravel-china.org/docs/5.5/authentication
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            //将系统的错误数据注入到视图变量$error中
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,

            //检验CSRF, 防止跨站请求伪造的安全威胁
            \App\Http\Middleware\VerifyCsrfToken::class,

            //处理路由绑定
            // 见：https://d.laravel-china.org/docs/5.5/routing#route-model-binding
            \Illuminate\Routing\Middleware\SubstituteBindings::class,

            //记录用户最后活跃时间
            \App\Http\Middleware\RecordLastActivedTime::class,
        ],

        //api中间件路由 适用于 routes/api.php文件
        'api' => [
            //使用别名来调用中间件
            // 请见：https://d.laravel-china.org/docs/5.5/middleware#为路由分配中间件
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     * 中间件别名设置，允许你用别名调用中间件
     * @var array
     */

    protected $routeMiddleware = [
        //只有登录用户才能访问，我们在控制器的构造方法中大量使用
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,

        //HTTP Basic Auth 认证
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,

        //处理路由绑定
        // 见：https://d.laravel-china.org/docs/5.5/routing#route-model-binding
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,

        //用户授权功能
        'can' => \Illuminate\Auth\Middleware\Authorize::class,

        //只有游客才能访问， 在register和login 请求中使用，只有未登录用户才能访问这些页面
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,

        //访问节流，类似于 【1分钟只能请求10次】的需求，一般在api中使用
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
    ];
}
