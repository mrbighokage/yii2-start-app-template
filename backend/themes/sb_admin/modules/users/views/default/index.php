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

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panel' => [
            'heading' => Html::tag('h3', Icon::show('lock') . Yii::t('users', 'Users'), ['class' => 'panel-title']) ,
            'type' => 'default',
            'before' => Html::a(Icon::show('plus') . Yii::t('users', 'New'), ['create'], ['class' => 'btn btn-success']),
            'after' => Html::a(Icon::show('repeat') . Yii::t('users', 'Reset'), ['index'], ['class' => 'btn btn-info'])
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'username',
            'email:email',
            [
                'attribute' => 'status',
                'filter' => Html::activeDropDownList($searchModel, 'status',User::getStatusList(), ['class' => 'form-control', 'prompt' => Yii::t('users', 'Status')]),
                'value' => function($model) {
                    return  User::getStatus($model->status);
                }
            ],
            'updated_at:datetime',
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
                            $link = Url::toRoute(['update', 'id' => $model->id]);
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
