<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'sourceLanguage' => 'en-US', // source language
    'language' => 'en-US', // current language
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
                    'forceTranslation' => true,
                ],
                'user' => [
                    'class' => 'yii\i18n\DbMessageSource',
                    //'forceTranslation' => true,
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
        ],
    ],
];
