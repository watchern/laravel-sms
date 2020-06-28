<?php

/*
 * This file is part of charles/laravel-sms.
 *
 * (c) Charles <https://www.charles.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [
    /*
    |--------------------------------------------------------------------------
    | 内置路由
    |--------------------------------------------------------------------------
    |
    | 如果是 web 应用建议 middleware 为 ['web', ...]
    | 如果是 api 应用建议 middleware 为 ['api', ...]
    |
    */
    'route' => [
        'enable' => true,
        'prefix' => 'sms',
        'middleware' => ['web'],
    ],

    /*
    |--------------------------------------------------------------------------
    | 请求间隔
    |--------------------------------------------------------------------------
    |
    | 单位：秒
    |
    */
    'interval' => 60,

    'easy_sms' => [
        // HTTP 请求的超时时间（秒）
        'timeout' => 5.0,

        // 默认发送配置
        'default' => [
            // 网关调用策略，默认：顺序调用
            'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,

            // 默认可用的发送网关
            'gateways' => [
                'errorlog',
            ],
        ],

        // 可用的网关配置
        'gateways' => [
            'errorlog' => [
                'file' => storage_path('logs/laravel-sms.log'),
            ],

            'yunpian' => [
                'api_key' => '824f0ff2f71cab52936axxxxxxxxxx',
            ],

            'aliyun' => [
                'access_key_id' => 'xxxx',
                'access_key_secret' => 'xxxx',
                'sign_name' => '阿里云短信测试专用',
                'code_template_id' => 'SMS_802xxx',
            ],

            'alidayu' => [
                //...
            ],
        ],
    ],

    /*
      |--------------------------------------------------------------------------
      | 验证码管理
      |--------------------------------------------------------------------------
      |
      | - length        验证码长度
      | - validMinutes  验证码有效时间长度，单位为分钟
      | - repeatIfValid 如果原验证码还有效，是否重复使用原验证码
      | - maxAttempts   验证码最大尝试验证次数，超过该数值验证码自动失效，0或负数则不启用
      |
      */
    'code' => [
        'length' => 5,
        'validMinutes' => 5,
        'repeatIfValid' => false,
        'maxAttempts' => 0,
    ],

    'data' => [
        'product' => '',
    ],

    /*
    |--------------------------------------------------------------------------
    | 是否数据库记录发送日志
    |--------------------------------------------------------------------------
    |
    | 若需开启此功能,需要先生成一个内置的'laravel_sms'表
    | 运行'php artisan migrate'命令可以自动生成
    |
    */
    'dbLog' => false,

    /*
    |--------------------------------------------------------------------------
    | 存储系统配置
    |--------------------------------------------------------------------------
    |
    | driver:
    | 存储方式,是一个实现了'Toplan\Sms\Storage'接口的类的类名,
    | 内置可选的值有'Toplan\Sms\SessionStorage'和'Toplan\Sms\CacheStorage',
    | 如果不填写driver,那么系统会自动根据内置路由的属性(route)中middleware的配置值选择存储器driver:
    | - 如果中间件含有'web',会选择使用'Toplan\Sms\SessionStorage'
    | - 如果中间件含有'api',会选择使用'Toplan\Sms\CacheStorage'
    |
    | prefix:
    | 存储key的prefix
    |
    | 内置driver的个性化配置:
    | - 在laravel项目的'config/session.php'文件中可以对'Toplan\Sms\SessionStorage'进行更多个性化设置
    | - 在laravel项目的'config/cache.php'文件中可以对'Toplan\Sms\CacheStorage'进行更多个性化设置
    |
    */
    'storage' => \Charles\Sms\Storage\CacheStorage::class,

    /*
    |--------------------------------------------------------------------------
    | 验证码短信通用内容
    |--------------------------------------------------------------------------
    |
    | 如需缓存配置，则需使用 `Toplan\Sms\SmsManger::closure($closure)` 方法进行配置
    |
    */
    'content' => '【your app signature】亲爱的用户，您的验证码是%s。有效期为%s分钟，请尽快验证。',

    'enable_rate_limit' => env('SMS_ENABLE_RATE_LIMIT', false), // 本插件是否开启
    
    // 请求次数限制，
    // rate_limit_middleware:rate_limit_count,rate_limit_time
    // rate_limit_time分钟内最大请求rate_limit_count此

    'rate_limit_middleware' => 'Charles\Sms\Http\Middleware\ThrottleRequests', // 请求次数并限制中间件

    'rate_limit_count' => env('SMS_RATE_LIMIT_COUNT', 10), // 请求次数限制

    'rate_limit_time' => env('SMS_RATE_LIMIT_TIME', 60), // 请求分钟限制

    /*
    |--------------------------------------------------------------------------
    | 验证码模块提示信息
    |--------------------------------------------------------------------------
    |
    */
    'notifies' => [
        // 频繁请求无效的提示
        'request_invalid' => '请求无效，请在%s秒后重试',

        // 验证码短信发送失败的提示
        'sms_sent_failure' => '短信验证码发送失败，请稍后重试',

        // 语音验证码发送发送成功的提示
        'voice_sent_failure' => '语音验证码请求失败，请稍后重试',

        // 验证码短信发送成功的提示
        'sms_sent_success' => '短信验证码发送成功，请注意查收',

        // 语音验证码发送发送成功的提示
        'voice_sent_success' => '语音验证码发送成功，请注意接听',
    ],
];
