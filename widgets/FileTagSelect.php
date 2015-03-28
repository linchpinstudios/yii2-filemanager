<?php
/**
 * @link http://www.linchpinstudios.com/
 * @copyright Copyright (c) 2014 Linchpin Studios LLC
 * @license http://opensource.org/licenses/MIT
 */

namespace linchpinstudios\filemanager\widgets;

use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\widgets\InputWidget;
use linchpinstudios\filemanager\models\FileTag;



/*
 * @author Josh Hagel <joshhagel@linchpinstudios.com>
 * @since 0.1
 */

 class FileTagSelect extends InputWidget
 {
    /**
     * @var array the options for the DateTime JS plugin.
     * Please refer to the DateTime JS plugin Web page for possible options.
     * @see http://xdsoft.net/jqplugins/datetimepicker/
     */
    public $clientOptions = [];




    /**
     * run function.
     *
     * @access public
     * @return void
     */
    public function run()
    {

        $randomId = uniqid();

        $tagsArray = ArrayHelper::map( FiltTag::find()->select(['id', 'name']))->all(), 'id', 'name' );

        $selectOptions = ArrayHelper::merge(['' => 'Select a File Tag'], $tagsArray);

        if ($this->hasModel()) {
            echo Html::activeDropDownList($this->model, $this->attribute, $selectOptions, $this->options);
        } else {
            echo Html::dropDownList($this->name, $this->value, $selectOptions, $this->options);
        }

    }

 }
