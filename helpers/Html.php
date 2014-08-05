<?php
/**
 * @link http://www.linchpinstudios.com/
 * @copyright Copyright (c) 2014 Linchpin Studios LLC
 * @license http://opensource.org/licenses/MIT
 */

namespace linchpinstudios\filemanager\helpers;

use Yii;
use yii\web\ErrorHandler;
use linchpinstudios\filemanager\models\Files;


/**
 * @author Josh Hagel <joshhagel@linchpinstudios.com>
 * @since 0.1
 */
 
 class Html extends \yii\helpers\Html
 {
    
    /**
     * run function.
     * 
     * @access public
     * @return void
     */
    public static function FileOutput($id = 0,$options = [],$urlOnly = false)
    {
        
        $awsConfig = \Yii::$app->getModule('filemanager')->aws;
        
        $path = \Yii::$app->getModule('filemanager')->path;
        
        if($awsConfig['enable']){
            $url = $awsConfig['url'];
        }else{
            $url = '';
        }
        
        if($id == 0){
            throw new \Exception('Please set ID');
        }
        
        $file = Files::findOne($id);
        
        if(!$file){
            throw new \Exception('Please select a file');
        }
        
        
        
        if($urlOnly){
            $return = $url.$file->url;
        }else{
            $return = Html::img($url.$file->url,$options);
        }
        
        return $return;
    }
    
 }