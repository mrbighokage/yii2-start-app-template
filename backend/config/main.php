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
                'slides>' => 'slides/default/index',
            ]
        ],
        'errorHandler' => [
            'errorAction' => 'admin/default/error'
        ],
        'view' => [
            'theme' => 'backend\themes\sb_admin\Theme'
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
