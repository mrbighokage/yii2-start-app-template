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
            ]
        ],
        'errorHandler' => [
            'errorAction' => 'admin/default/error'
        ],
        'view' => [
            'theme' => [
                'basePath' => '@app/themes/sb_admin',
                'baseUrl' => '@web/themes/sb_admin',
                'pathMap' => [
                    '@app/views' => [
                        '@app/themes/sb_admin/modules/admin/views',
                        '@app/themes/sb_admin',
                    ],
                    '@app/modules' => [
                        '@app/themes/sb_admin/modules',
                    ]
                ],
            ],
        ],
        'user' => [
            'identityClass' => 'common\modules\users\models\User',
            'enableAutoLogin' => false,
            'loginUrl' => 'admin/login'
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
    ],
    'params' => $params,
];
