<?php

namespace linchpinstudios\filemanager;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'linchpinstudios\filemanager\controllers';
    
    public $thumnails = [[100,100]];
    
    public $path = '@web/files/';
    
    public $thumbPath = '@web/files/thumb/';
    
    public $aws = [
        'key' => '',
        'secret' => '',
    	'bucket' => '',
    ];
    
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}

