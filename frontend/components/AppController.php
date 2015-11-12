<?php
namespace frontend\components;

use Yii;
use yii\web\Controller;

/**
 * Root frontend controller
 */
class AppController extends Controller
{

    public $showMainSlider = false;

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {

            //Yii::$app->view->params['showMainSlider'] = &$this->showMainSlider;

            return true;
        }
        return false;
    }

}
