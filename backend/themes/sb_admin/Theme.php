<?php

namespace backend\themes\sb_admin;

use Yii;

class Theme extends \yii\base\Theme
{
    /**
     * @inheritdoc
     */
    public $pathMap = [
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
    ];
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        /*
        Yii::$app->assetManager->bundles['yii\bootstrap\BootstrapAsset'] = [
            'sourcePath' => '@alias/themes/site/assets',
            'css' => [
                'css/bootstrap.min.css'
            ]
        ];
        Yii::$app->assetManager->bundles['yii\bootstrap\BootstrapPluginAsset'] = [
            'sourcePath' => 'alias/themes/site/assets',
            'js' => [
                'js/bootstrap.min.js'
            ]
        ];
        */
    }
}