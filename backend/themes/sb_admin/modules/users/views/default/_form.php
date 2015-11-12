<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use common\modules\users\models\User;

$role = current(Yii::$app->getAuthManager()->getRolesByUser($model->id));
if($role) {
    $model->role = $role->name;
}
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput() ?>
    <?= $form->field($model, 'email')->textInput() ?>

    <?= $form->field($model, 'role')->widget(Select2::classname(), [
            'data' => User::getRolesList(),
            'language' => 'en',
            'options' => ['placeholder' => 'Select a role ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
    ]); ?>

    <?= $form->field($model, 'password')->passwordInput() ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
