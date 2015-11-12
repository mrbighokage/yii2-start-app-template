<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'sourceLanguage' => 'ru-RU', // source language
    'language' => 'ru-RU', // current language
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],

        /*
         * create config file
         * # yii message/config "\www\domains\yii2_start_app_template\console\messages\config.php"
         *
         * extract translate
         * # yii message/extract "\www\domains\yii2_start_app_template\console\messages\config.php"
         * */
        'i18n' => [
            'translations' => [
                'app' => [
                    'class' => 'yii\i18n\DbMessageSource',
                    'forceTranslation' => false,
                ],
                'users' => [
                    'class' => 'yii\i18n\DbMessageSource',
                    'forceTranslation' => false,
                ],
                'admin' => [
                    'class' => 'yii\i18n\DbMessageSource',
                    'forceTranslation' => false,
                ]
            ],
        ],

        /*
         * configure console/controllers/RbacController.php
         * # yii rbac/init
         * to prepare base RBAC access
         * */
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            /*'defaultRoles' => [
                common\modules\users\models\User::ROLE_GUEST
            ]*/
        ],
    ],
];
