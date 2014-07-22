<?php

namespace linchpinstudios\filemanager\controllers;

use yii;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    
    public function actionUpload()
    {
           
        $items = ['some', 'array', 'of', 'values' => ['associative', 'array']];
        \Yii::$app->response->format = 'json';
        return $items;
    }
    
    
    
}
