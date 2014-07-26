<?php

namespace linchpinstudios\filemanager;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'linchpinstudios\filemanager\controllers';
    
    public $thumnails = [[100,100]];
    
    public $path = 'files/';
    
    public $thumbPath = '@web/files/thumb/';
    
    public $aws = [
        'enable' => false,
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

