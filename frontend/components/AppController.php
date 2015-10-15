<?php
namespace frontend\components;

use Yii;
use yii\web\Controller;

/**
 * Root frontend controller
 */
class AppController extends Controller
{

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            return true;
        }
        return false;
    }

}
