<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\modules\site\controllers',
    'defaultRoute' => 'site',
    'homeUrl' => '/',
    'components' => [
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'baseUrl' => '/',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                // global rule
                // ModuleID/ControllerID/ActionID

                '<action:about|contact|index>' => 'site/default/<action>',
                '<action:signup|login>' => 'users/default/<action>',

                '<controller:site>/<action:captcha>' => 'site/default/<action>',
            ]
        ],
        'errorHandler' => [
            'errorAction' => 'site/default/error'
        ],
        'view' => [
            'theme' => [
                'basePath' => '@app/themes/basic',
                'baseUrl' => '@web/themes/basic',
                'pathMap' => [
                    '@app/views' => [
                        '@app/themes/basic/modules/site/views',
                        '@app/themes/basic',
                    ],
                    '@app/modules' => [
                        '@app/themes/basic/modules',
                    ]
                ],
            ],
        ],
        'request' => [
            'baseUrl' => '/',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
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
        'site' => [
            'class' => 'frontend\modules\site\Module'
        ],
        'users' => [
            'class' => 'frontend\modules\users\Module'
        ],
    ],
    'params' => $params,
];
