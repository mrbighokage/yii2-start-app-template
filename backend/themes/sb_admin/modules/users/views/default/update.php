<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\users\models\User */

$this->title = Yii::t('users', 'Update user "{user}"', [
    'user' => $model->username,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('users', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('users', 'Update');
?>
<div class="user-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
