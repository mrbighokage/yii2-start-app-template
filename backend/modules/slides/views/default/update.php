<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\Slides\models\Slide */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
        'modelClass' => 'Slide',
    ]) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Slides'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="slide-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>