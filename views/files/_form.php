<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model linchpinstudios\filemanager\models\Files */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="files-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'width')->textInput() ?>

    <?= $form->field($model, 'height')->textInput() ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <?= $form->field($model, 'date_gmt')->textInput() ?>

    <?= $form->field($model, 'update')->textInput() ?>

    <?= $form->field($model, 'update_gmt')->textInput() ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => 555]) ?>

    <?= $form->field($model, 'file_name')->textInput(['maxlength' => 555]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 555]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => 555]) ?>

    <?= $form->field($model, 'type')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'size')->textInput(['maxlength' => 45]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
