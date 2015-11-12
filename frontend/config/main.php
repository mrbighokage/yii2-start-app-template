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
    'defaultRoute' => 'default',
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
                '<action:signup|signin|logout>' => 'users/default/<action>',
                '<action:auth>' => 'users/default/auth',
                '<action:development>' => 'site/default/development',

                'site/site/captcha' => 'site/default/captcha',


                'request-password-reset' => 'users/default/request-password-reset',
                'reset-password' => 'users/default/reset-password'
            ]
        ],
        'errorHandler' => [
            'errorAction' => 'site/default/error'
        ],
        'view' => [
            'theme' => 'frontend\themes\basic\Theme'
        ],
        'request' => [
            'baseUrl' => '/',
        ],
        'user' => [
            'identityClass' => 'common\modules\users\models\User',
            'enableAutoLogin' => false,
            'loginUrl' => ['users/default/login'],
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
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'google'   => [
                    'class'        => 'frontend\modules\users\components\OAuthGoogleClient',
                    //'clientId'     => '130875484425-fdi9vuitu9ua25bn76j8vgbt4o9kjmsj.apps.googleusercontent.com',
                    //'clientSecret' => 'AJptAA7wOVv4T3DmlB4XuOC-',
                ],
                'facebook' => [
                    'class'        => 'frontend\modules\users\components\OAuthFacebookClient',
                    //'clientId'     => '975550292496100',
                    //'clientSecret' => 'fce19970b990890aac1e98f44dd6d6e8',
                ],
                'linkedin' => [
                    'class'        => 'frontend\modules\users\components\OAuthLinkedInClient',
                    //'clientId'     => '77bkixqhqz12lu',
                    //'clientSecret' => 'VKNoeKgwyTXVWozH',
                ],
                'twitter' => [
                    'class' => 'frontend\modules\users\components\OAuthTwitterClient',
                    //'consumerKey' => 'twitter_consumer_key',
                    //'consumerSecret' => 'twitter_consumer_secret',
                ],
                'vkontakte' => [
                  'class' => 'frontend\modules\users\components\OAuthVKontakteClient',
                  //'clientId' => 'vkontakte_client_id',
                  //'clientSecret' => 'vkontakte_client_secret',
                ],
            ],
        ]
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
