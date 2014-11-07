<?php

use yii\grid\GridView;
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
    $path = $awsConfig['url'];
}else{
    $path = '';
}

?>

<div class="filemanager-default-index">

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="pull-left">
                <?= Html::a(Html::tag('i','',['class' => 'glyphicon glyphicon-th-large']), ['#'], ['data-toggle' => 'modal', 'class' => 'btn btn-primary navbar-btn disabled', 'id' => 'fileGridBtn']); ?>
                <?= Html::a(Html::tag('i','',['class' => 'glyphicon glyphicon-cloud-upload']), ['#'], ['class' => 'btn btn-success navbar-btn', 'data-toggle' => 'modal', 'id' => 'fileUploadBtn']); ?>
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
            
            <!--<form class="navbar-form navbar-right" role="search">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search">
                </div>
                <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i></button>
            </form> -->
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">
            <div class="display-images" id="fileGridManager">
                <div class="row">
                    <?php
                        
                        $models = $dataProvider->getModels();
                        
                        foreach($models as $m){
                            
                            echo '<div class="col-xs-6 col-sm-4 col-md-3 image-thumbnail" data-id="'.$m->id.'">';
                                echo Html::a(Html::tag('span',$m->id).'<img src="'.$path.$m->thumbnail_url.'" style="height:'.$this->context->module->thumbnails[0][1].'px;">',Html::FileOutput($m->id,[],true),['class'=>'thumbnail']);
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
                    ]
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


<script>
    
    
    
</script>



<div class="modal fade" id="editProperties" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body"></div>
            
        </div>
    </div>
</div>


