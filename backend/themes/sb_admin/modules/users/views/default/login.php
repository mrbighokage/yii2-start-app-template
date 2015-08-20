<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\admin\widgets\Alert;

$this->title = Yii::t('users', 'Please Sign In');
?>
<div class="c-login container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
                </div>
                <div class="panel-body">
                    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                    <?= $form->field($model, 'username')->textInput(['placeholder' => Yii::t('users', 'Username')])->label(null, ['hidden' => 'hidden']); ?>
                    <?= $form->field($model, 'password')->passwordInput(['placeholder' => Yii::t('users', 'Password')])->label(null, ['hidden' => 'hidden']) ?>
                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('users', 'Login'), ['class' => 'btn btn-lg btn-info btn-block', 'name' => 'login-button']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                    <?= Alert::widget() ?>
                </div>
            </div>
        </div>
    </div>
</div>
