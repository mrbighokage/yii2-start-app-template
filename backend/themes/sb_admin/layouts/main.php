<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\themes\sb_admin\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

use backend\modules\admin\widgets\SideMenu;
use backend\modules\admin\widgets\Alert;

use kartik\icons\Icon;

AppAsset::register($this);
Icon::map($this); // default Icon::FA

$class_maximize = Yii::$app->request->cookies->get('min_show') ? 'maximize' : '';
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language; ?>">
    <head>
        <title><?= Yii::$app->params['siteName'] . ' - ' . Html::encode($this->title) ?></title>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>

        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>
    <div id="wrapper">

        <?php
        echo $this->render('//layouts/top-menu');
        echo SideMenu::widget(['class' => $this]);
        ?>

        <div id="page-wrapper" class="<?= $class_maximize ?>">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><?= $this->title ?></h1>
                </div>
            </div>
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                'homeLink' => [
                    'label' => Yii::t('app', 'Dashboard'),
                    'url' => Yii::$app->homeUrl
                ]
            ]); ?>
            <?= Alert::widget() ?>
            <?= $content; ?>
        </div>

    </div>
    <footer class="footer">
        <div class="col-lg-12">
            <p class="pull-left">© <?= Yii::$app->params['siteName'] . ' ' . date('Y'); ?> </p>
            <p class="pull-right">Powered by <a href="http://www.yiiframework.com/" rel="external">Yii Framework</a></p>
        </div>
    </footer>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>