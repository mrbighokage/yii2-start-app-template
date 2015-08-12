<?php

namespace frontend\modules\site;

use Yii;

// ********************
// root frontend module
// ********************
class Module extends \yii\base\Module
{
    public $controllerNamespace = 'frontend\modules\site\controllers';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
        //  Yii::$app->errorHandler->errorAction = 'site/default/error';
    }
}
