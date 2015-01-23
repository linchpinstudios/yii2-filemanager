<?php

namespace linchpinstudios\filemanager;

/**
 * Module class.
 */
class Module extends \yii\base\Module
{
    
    public $controllerNamespace = 'linchpinstudios\filemanager\controllers';
    
    public $thumbnails = [[100,100]];
    
    public $directory = '@webroot/';
    
    public $path = 'images/uploads/';
    
    public $thumbPath = 'images/uploads/thumb/';
    
    public $url = '/';
    
    public $aws = [
        'enable'    => false,
        'key'       => '',
        'secret'    => '',
    	'bucket'    => '',
    ];
    
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}

