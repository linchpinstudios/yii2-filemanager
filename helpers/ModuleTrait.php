<?php

namespace linchpinstudios\filemanager\helpers;

/**
 * @property \linchpinstudios\filemanager\Module $module
 */
trait ModuleTrait
{
    /**
     * @var null|\linchpinstudios\filemanager\Module
     */
    private $_module;

    /**
     * @return null|\linchpinstudios\filemanager\Module
     */
    protected function getModule()
    {
        if ($this->_module == null) {
            $this->_module = \Yii::$app->getModule('filemanager');
        }

        return $this->_module;
    }
}