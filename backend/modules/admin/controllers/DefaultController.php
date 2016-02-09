<?php
namespace backend\modules\admin\controllers;

use Imagine\Image\Box;
use Imagine\Image\ManipulatorInterface;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\Cookie;
use yii\web\Response;
use yii\imagine\Image;

use common\modules\users\models\User;

/**
 * Site controller
 */
class DefaultController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['error'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['index', 'set-cookie', 'get-cookie'],
                        'allow' => true,
                        'roles' => [User::ROLE_ADMIN],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        /*$file = Yii::getAlias('@uploads/black-wallpaper.jpg');

        Image::$driver = Yii::$app->params['imageDriver'];
        $imagine = Image::getImagine();
        print_r($imagine);
        $image = $imagine->open($file);
        $size = $image->getSize();
        $scale = null;
        $box = null;
        if($size->getWidth() > 1280 && $size->getHeight() < 1280) {
            $scale = round(1280*$size->getHeight()/$size->getWidth());
            $box = new Box(1280, $scale);
        } elseif($size->getWidth() < 1280 && $size->getHeight() > 1280) {
            $scale = round(1280*$size->getWidth()/$size->getHeight());
            $box = new Box($scale, 1280);
        } else {
            $scale = round(1280*$size->getHeight()/$size->getWidth());
            $box = new Box(1280, $scale);
        }
        if($box) {
            $mode = ArrayHelper::getValue([], 'mode', ManipulatorInterface::THUMBNAIL_OUTBOUND);
            $image = $image->thumbnail($box, $mode);

            $thumbPath = Yii::getAlias('@uploads/black-wallpaper.jpg');
            $image->save($thumbPath);
        }*/

        return $this->render('index');
    }

    public function actionSetCookie() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $code = 400;
        $message = Yii::t('admin', 'Cookie not set.');
        if(Yii::$app->request->isAjax) {
            $key = Yii::$app->request->post('key', '');
            $value = Yii::$app->request->post('value', '');
            if($key) {
                if(Yii::$app->request->cookies->has($key)) {
                    Yii::$app->response->cookies->remove($key);
                }
                if($value) {
                    Yii::$app->response->cookies->add(new Cookie([
                        'name' => $key,
                        'value' => $value,
                        'expire' => time() + 86400 * 365,
                    ]));
                }
                $code = 200;
                $message = '';
            }
        }
        return [
            'code' => $code,
            'message' => $message,
        ];
    }

    public function actionGetCookie() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $code = 400;
        $message = Yii::t('admin', 'Cookie not set.');
        $value = null;
        if(Yii::$app->request->isAjax) {
            $key = Yii::$app->request->post('key', '');
            if($key) {
                $value = Yii::$app->request->cookies->get($key);
                $code = 200;
                $message = '';
            }
        }
        return [
            'code' => $code,
            'message' => $message,
            'value' => $value
        ];
    }

}
