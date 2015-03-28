<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model linchpinstudios\filemanager\models\Files */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="files-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-12 col-md-9">



            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <strong>Details</strong>
                        </div>
                        <div class="panel-body">

                            <div class="row">
                                <div class="col-sm-12 col-md-3">
                                    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <?= $form->field($model, 'file_name')->textInput(['maxlength' => true]) ?>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <?= $form->field($model, 'width')->textInput() ?>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <?= $form->field($model, 'height')->textInput() ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <?= $form->field($model, 'thumbnail_url')->textInput(['maxlength' => true]) ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">

                    <div class="panel pandel-default">
                        <div class="panel-heading">
                            <strong>Tags</strong>
                            <?= Html::a('<i class="glyphicon glyphicon-plus-sign"></i> Add', ['#'], ['class' => 'pull-right', 'data-toggle' => 'modal', 'data-target' => '#myModal']) ?>
                        </div>
                        <div class="panel-body">

                            <div class="row">
                                <?php
                                    $availableTags = ArrayHelper::map($tags, 'id', 'name');
                                    $preselectedTags = ArrayHelper::map(ArrayHelper::toArray($model->tags), 'name', 'id' );
                                ?>
                                <?= Html::checkboxList('tags',$preselectedTags,$availableTags,['id' => 'tag-con', 'separator'=>'', 'item' => function ($index, $label, $name, $checked, $value){
                                    return '<div class="col-md-3">' . Html::checkbox($name, $checked, ['value' => $value, 'label' => $label, ]) . '</div>';
                                }]) ?>
                            </div>

                        </div>
                    </div>

                </div>
            </div>


        </div>
        <div class="col-sm-12 col-md-3">

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>Tags</strong>
                </div>
                <div class="panel-body">

                    <?= $form->field($model, 'user_id')->textInput() ?>

                    <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'size')->textInput() ?>

                </div>
            </div>

        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>



<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add Tag</h4>
      </div>
      <?php
          $formTag = ActiveForm::begin([
              'action'                    => ['//filemanager/file-tag/createtag'],
              'enableAjaxValidation'      => false,
              'enableClientValidation'    => true,
              'id'                        => 'create_tag',
          ]);
      ?>
          <div class="modal-body">
              <?= $formTag->field($newTag, 'name')->textInput(['maxlength' => 255]) ?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <?= Html::submitButton('<i class="glyphicon glyphicon-plus-sign"></i> Create', ['class' => 'btn btn-success', 'id' => 'create-category']) ?>
          </div>
      <?php ActiveForm::end(); ?>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
