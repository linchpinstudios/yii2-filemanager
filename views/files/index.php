<?php

use yii\grid\GridView;
use yii\helpers\Url;
use dosamigos\fileupload\FileUploadUI;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
use linchpinstudios\filemanager\helpers\Html;


/* @var $this yii\web\View */
/* @var $searchModel linchpinstudios\filemanager\models\FilesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Files';
$this->params['breadcrumbs'][] = $this->title;

$awsConfig = $this->context->module->aws;

if($awsConfig['enable']){
    $path = $this->context->module->url;
}else{
    $path = '/';
}

?>

<div class="filemanager-default-index">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="pull-left">
                        <?= Html::a(Html::tag('i','',['class' => 'glyphicon glyphicon-th-large']), '#', ['class' => 'btn btn-primary navbar-btn disabled', 'id' => 'fileGridBtn']); ?>
                        <?= Html::a(Html::tag('i','',['class' => 'glyphicon glyphicon-cloud-upload']), '#', ['class' => 'btn btn-success navbar-btn', 'id' => 'fileUploadBtn']); ?>
                    </div>

                    <?php
                        $form = ActiveForm::begin([
                            'id' => 'file-search-form',
                            'method' => 'get',
                            'options' => ['class' => 'navbar-form navbar-right'],
                        ]);

                        echo Html::beginTag('div',['class' => 'form-group']);
                            echo $form->field($searchModel, 'title')->textInput(['class' => 'form-control', 'placeholder' => 'Search']);
                        echo Html::endTag('div');
                            echo Html::submitButton('<i class="glyphicon glyphicon-search"></i>', ['class' => 'btn btn-primary']);
                    ActiveForm::end();
                    ?>

                    <div class="clearfix"></div>
                </div>

                <div class="panel-body">
                    <div class="display-images" id="fileGridManager">
                        <div class="row">
                            <?php

                                $models = $dataProvider->getModels();

                                foreach($models as $m){

                                    echo '<div class="col-xs-6 col-sm-4 col-md-3 image-thumbnail">';
                                        echo Html::a( '<img src="'.$path.$m->thumbnail_url.'" style="height:'.$this->context->module->thumbnails[0][1].'px;">', ['view', 'id' => $m->id],['class'=>'thumbnail',  'data-id' => $m->id]);
                                    echo '</div>';

                                }
                            ?>
                        </div>
                    </div>
                    <div class="upload-images" id="filemanagerUpload">
                        <?= FileUploadUI::widget([
                            'model' => $model,
                            'attribute' => 'file_name',
                            'url' => ['files/upload'], // your url, this is just for demo purposes,
                            'options' => [
                                'accept' => 'image/*',
                                'done'   => 'filemanager',
                            ],
                            'clientOptions' => [
                                'maxFileSize' => 2000000,
                                'debug' => true,
                            ],
                            'clientEvents' => [
                                'fileuploaddone' => 'function(e, data) {
                                    console.log(data);
                                    $.each(data.result.files, function( index, value ){
                                        console.log(value);
                                        $("#fileGridManager .row").prepend(\'<div class="col-xs-6 col-sm-4 col-md-3 image-thumbnail"><a class="thumbnail" href="' . Url::to(['view']) . '?id=\' + value.id + \'" data-id="\' + value.id + \'"><img src="\' + value.thumbnailUrl + \'"></a></div>\');
                                        $(\'#filemanagerUpload\').hide();
                                        $(\'#fileGridManager,#fileGridFooter\').show();
                                    });
                                }',
                                'fileuploadfail' => 'function(e, data) {
                                    console.log(e);
                                    console.log(data);
                                }',
                            ],
                        ]);?>
                    </div>
                </div>

                <div class="panel-footer" id="fileGridFooter">
                    <?php

                        echo linkPager::widget([
                            'pagination'=>$dataProvider->pagination,
                        ]);

                    ?>
                </div>

            </div>
        </div>

    </div>

</div>
