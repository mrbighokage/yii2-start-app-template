<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\modules\admin\controllers',
    'defaultRoute' => 'default',
    'bootstrap' => ['log'],
    'homeUrl' => '/admin',
    'language' => 'en-US',
    'components' => [
        'request' => [
            'baseUrl' => '/admin',
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'baseUrl' => '/admin',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                // global rule
                // ModuleID/ControllerID/ActionID

                '<action:index>' => 'admin/default/<action>',
                '<action:login|logout>' => 'users/default/<action>',

                'slides/<action>' => 'slides/default/<action>',
                'slides' => 'slides/default/index',
            ]
        ],
        'errorHandler' => [
            'errorAction' => 'admin/default/error'
        ],
        /*'view' => [
            'theme' => 'backend\themes\sb_admin\Theme'
        ],*/
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => [
                        '@app/views',
                        '@app/modules/admin/views'
                    ],
                    '@app/modules/users/views' => [
                        '@app/views',
                    ],
                    /*
                        // base LTE theme
                        // https://almsaeedstudio.com
                        '@app/views' => '@vendor/dmstr/yii2-adminlte-asset/example-views/phundament/app'

                        // customize views
                        '@app/views' => [
                            '@app/themes/sb_admin/modules/admin/views',
                            '@app/themes/sb_admin',
                        ],
                                '@app/modules' => [
                            '@app/themes/sb_admin/modules',
                        ],
                                '@app/modules/users/views' => [
                            '@app/themes/sb_admin',
                        ],
                    */
                ],
            ],
        ],
        'assetManager' => [
            'bundles' => [
                'dmstr\web\AdminLteAsset' => [
                    'skin' => 'skin-blue',
                    /*
                        "skin-blue",
                        "skin-black",
                    */
                ],
            ],
        ],
        'user' => [
            'identityClass' => 'common\modules\users\models\User',
            'enableAutoLogin' => false,
            'loginUrl' => '/admin/login'
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
    'modules' => [
        'admin' => [
            'class' => 'backend\modules\admin\Module'
        ],
        'users' => [
            'class' => 'backend\modules\users\Module'
        ],
        'slides' => [
            'class' => 'backend\modules\slides\Module'
        ],
        'gridview' =>  [
            'class' => '\kartik\grid\Module'
        ]
    ],
    'params' => $params,
];
