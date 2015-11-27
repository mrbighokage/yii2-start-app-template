<?php

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\users\models\search\SearchUser */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\icons\Icon;

use common\modules\users\models\User;

$this->title = Yii::t('users', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'hover' => true,
        'showPageSummary' => false,
        'responsive' => true,
        'showFooter' => false,
        'export' => false,
        'pjax' => true,
        'bordered' => true,
        'striped' => false,
        'condensed' => false,
        'panel' => [
            'heading' => Html::tag('h3', Icon::show('users') . Yii::t('users', 'User list'), ['class' => 'panel-title']) ,
            //'before' => Html::a(Icon::show('plus') . Yii::t('users', 'New'), ['create'], ['class' => 'btn btn-success']),
            //'after' => Html::a(Icon::show('repeat') . Yii::t('users', 'Reset'), ['index'], ['class' => 'btn btn-info']),
            'type' => GridView::TYPE_DEFAULT,
        ],
        /*'beforeHeader'=>[
            [
                'columns'=>[
                    ['content'=>'Header Before 1', 'options'=>['colspan'=>4, 'class'=>'text-center warning']],
                    ['content'=>'Header Before 2', 'options'=>['colspan'=>4, 'class'=>'text-center warning']],
                    ['content'=>'Header Before 3', 'options'=>['colspan'=>3, 'class'=>'text-center warning']],
                ],
                'options'=>['class'=>'skip-export'] // remove this row from export
            ]
        ],*/
        'toolbar' => [
            [
                'content'=>
                    Html::a(Icon::show('plus'), ['create'], [
                        //'type'=>'button',
                        'title'=>Yii::t('users', 'Add User'),
                        'class'=>'btn btn-success'
                    ]) . ' '.
                    Html::a(Icon::show('repeat'), ['index'], [
                        'class' => 'btn btn-default',
                        'title' => Yii::t('users', 'Reset Grid')
                    ]),
            ],
            /*'{export}',
            '{toggleData}'*/
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'username',
            'email:email',
            'created_at:datetime',
            [
                'header' => Yii::t('users', 'Actions'),
                'class' => 'kartik\grid\ActionColumn',
                'dropdown' => false,
                'vAlign' => 'middle',
                'urlCreator' => function ($action, $model, $key, $index) {
                    $link = '#';
                    switch ($action) {
                        case 'view':
                            $link = Url::toRoute(['view', 'id' => $model->id]);
                            break;
                        case 'update':
                            $link = Url::toRoute(['update', 'id' => $model->id]);
                            break;
                        case 'delete':
                            $link = Url::toRoute(['delete', 'id' => $model->id]);
                            break;
                    }
                    return $link;
                },
                'viewOptions' => ['title' => Yii::t('users', 'Details')],
                'updateOptions' => ['title' => Yii::t('users', 'Edit page')],
                'deleteOptions' => ['title' => Yii::t('users', 'Delete action')],
            ],
        ],
    ]); ?>

</div>
