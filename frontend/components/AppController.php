<?php
namespace frontend\components;

use Yii;
use yii\web\Controller;

/**
 * Root frontend controller
 */
class AppController extends Controller
{

    /*
     * Example.
     *
     * AppController
     * public $showMainSlider = false;
     *
     * AppController beforeAction
     * Yii::$app->view->params['showMainSlider'] = &$this->showMainSlider;
     *
     * use in ChildController action
     * $this->showMainSlider = true
     *
     * use in views
     * if($this->params['showMainSlider']) {}
     *
     */

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            return true;
        }
        return false;
    }

}
