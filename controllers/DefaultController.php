<?php

namespace linchpinstudios\filemanager\controllers;

use yii;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $view = $this->getView();
/*
        DateTimePickerAssets::register($view);

        $id = $this->options['id'];

        $options = Json::encode($this->clientOptions);
*/
        $view->registerJs("\$(function(){\$('#filemanager-upload').modal();});");
    
        return $this->redirect(['files/index']);
    }
    
    
}
