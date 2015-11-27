<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\modules\slides\models\Slide;
use common\helpers\ThumbHelper;

$this->registerCss("
    .slide-form .row img {
        width: 180px;
        height: 38px;
    }
");

?>

<div class="slide-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="row">
        <div class="col-xs-6">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

            <div class="row">
                <div class="col-xs-3">
                    <?= $form->field($model, 'status')->dropDownList(Slide::getStatusList()) ?>
                </div>
                <!--<div class="col-xs-3">
                    <?php /*echo $form->field($model, 'type')->dropDownList(Slide::getTypeList()) */?>
                </div>-->
            </div>

            <div class="row">
                <div class="col-xs-8">
                    <?= $form->field($model, 'imageFile')->fileInput() ?>
                </div>
                <div class="col-xs-4">
                   <?= ThumbHelper::getImg($model->img, 180, 38)?>
                </div>
            </div>
            <?= $form->field($model, 'comment')->textarea(['maxlength' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>