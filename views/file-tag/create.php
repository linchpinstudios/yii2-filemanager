<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model linchpinstudios\filemanager\models\FileTag */

$this->title = Yii::t('app', 'Create File Tag');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'File Tags'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="file-tag-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
