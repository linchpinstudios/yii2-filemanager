<?php

use yii\helpers\Html;
use yii\grid\GridView;
use dosamigos\fileupload\FileUploadUI;


/* @var $this yii\web\View */
/* @var $searchModel linchpinstudios\filemanager\models\FilesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Files';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="filemanager-default-index">

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="pull-left">
                <?= Html::a(Html::tag('i','',['class' => 'glyphicon glyphicon-th-large']),['files/filemodal'],['data-toggle' => 'modal', 'data-target' => '#filemanagerUpload', 'class' => 'btn btn-default navbar-btn disabled',]); ?>
                <?= Html::a(Html::tag('i','',['class' => 'glyphicon glyphicon-cloud-upload']),['files/filemodal'],['class' => 'btn btn-default navbar-btn', 'data-toggle' => 'modal', 'data-target' => '#filemanagerUpload']); ?>
            </div>
            <form class="navbar-form navbar-right" role="search">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search">
                </div>
                <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i></button>
            </form>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">
            <div class="display-images">
                <div class="row">
                  <div class="col-xs-6 col-md-3">
                    <a href="#" class="thumbnail">
                      <img src="http://themes.goodlayers.com/modernize/wp-content/uploads/2012/01/Fotolia_21995387_Subscription_Monthly_XXL-390x250.jpg" alt="...">
                    </a>
                  </div>
                  <div class="col-xs-6 col-md-3">
                    <a href="#" class="thumbnail">
                      <img src="http://themes.goodlayers.com/modernize/wp-content/uploads/2012/01/Fotolia_21995387_Subscription_Monthly_XXL-390x250.jpg" alt="...">
                    </a>
                  </div>
                  <div class="col-xs-6 col-md-3">
                    <a href="#" class="thumbnail">
                      <img src="http://themes.goodlayers.com/modernize/wp-content/uploads/2012/01/Fotolia_21995387_Subscription_Monthly_XXL-390x250.jpg" alt="...">
                    </a>
                  </div>
                  <div class="col-xs-6 col-md-3">
                    <a href="#" class="thumbnail">
                      <img src="http://themes.goodlayers.com/modernize/wp-content/uploads/2012/01/Fotolia_21995387_Subscription_Monthly_XXL-390x250.jpg" alt="...">
                    </a>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-6 col-md-3">
                    <a href="#" class="thumbnail">
                      <img src="http://themes.goodlayers.com/modernize/wp-content/uploads/2012/01/Fotolia_21995387_Subscription_Monthly_XXL-390x250.jpg" alt="...">
                    </a>
                  </div>
                  <div class="col-xs-6 col-md-3">
                    <a href="#" class="thumbnail">
                      <img src="http://themes.goodlayers.com/modernize/wp-content/uploads/2012/01/Fotolia_21995387_Subscription_Monthly_XXL-390x250.jpg" alt="...">
                    </a>
                  </div>
                  <div class="col-xs-6 col-md-3">
                    <a href="#" class="thumbnail">
                      <img src="http://themes.goodlayers.com/modernize/wp-content/uploads/2012/01/Fotolia_21995387_Subscription_Monthly_XXL-390x250.jpg" alt="...">
                    </a>
                  </div>
                  <div class="col-xs-6 col-md-3">
                    <a href="#" class="thumbnail">
                      <img src="http://themes.goodlayers.com/modernize/wp-content/uploads/2012/01/Fotolia_21995387_Subscription_Monthly_XXL-390x250.jpg" alt="...">
                    </a>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-6 col-md-3">
                    <a href="#" class="thumbnail">
                      <img src="http://themes.goodlayers.com/modernize/wp-content/uploads/2012/01/Fotolia_21995387_Subscription_Monthly_XXL-390x250.jpg" alt="...">
                    </a>
                  </div>
                  <div class="col-xs-6 col-md-3">
                    <a href="#" class="thumbnail">
                      <img src="http://themes.goodlayers.com/modernize/wp-content/uploads/2012/01/Fotolia_21995387_Subscription_Monthly_XXL-390x250.jpg" alt="...">
                    </a>
                  </div>
                  <div class="col-xs-6 col-md-3">
                    <a href="#" class="thumbnail">
                      <img src="http://themes.goodlayers.com/modernize/wp-content/uploads/2012/01/Fotolia_21995387_Subscription_Monthly_XXL-390x250.jpg" alt="...">
                    </a>
                  </div>
                  <div class="col-xs-6 col-md-3">
                    <a href="#" class="thumbnail">
                      <img src="http://themes.goodlayers.com/modernize/wp-content/uploads/2012/01/Fotolia_21995387_Subscription_Monthly_XXL-390x250.jpg" alt="...">
                    </a>
                  </div>
                </div>
            </div>
            <div class="upload-images">
                <?= FileUploadUI::widget([
                    'model' => $model,
                    'attribute' => 'file_name',
                    'url' => ['files/upload'], // your url, this is just for demo purposes,
                    'options' => ['accept' => 'image/*'],
                    'clientOptions' => [
                        'maxFileSize' => 2000000
                    ]
                ]);?>
            </div>
        </div>
        <div class="panel-footer">
            <ul class="pagination" style="margin:0;">
                <li><a href="#">&laquo;</a></li>
                <li><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
                <li><a href="#">&raquo;</a></li>
            </ul>
        </div>
    </div>
    
</div>
