<?php
namespace backend\components;

use Yii;
use yii\web\Controller;

/**
 * Root backend controller
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
