<?php

namespace frontend\modules\site;

use Yii;
use frontend\components\AppModule;

class Module extends AppModule
{
    public $controllerNamespace = 'frontend\modules\site\controllers';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
        //  Yii::$app->errorHandler->errorAction = 'site/default/error';
    }
}
