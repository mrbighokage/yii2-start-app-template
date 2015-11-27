<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use common\modules\users\models\User;
use common\helpers\ThumbHelper;

$role = current(Yii::$app->getAuthManager()->getRolesByUser($model->id));
if($role) {
    $model->role = $role->name;
}
?>

<div class="user-form">

    <div class="row">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
            <div class="col-lg-6">

                <?= $form->field($model, 'first_name')->textInput() ?>
                <?= $form->field($model, 'last_name')->textInput() ?>

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

                <div class="row">
                    <div class="col-xs-8">
                        <?= $form->field($model, 'photoFile')->fileInput() ?>
                    </div>
                    <div class="col-xs-4">
                        <?= ThumbHelper::getImg($model->avatar, 100, 100, ['class' => 'pull-right'])?>
                    </div>
                </div>

                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>

            </div>

            <div class="col-lg-6">
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
