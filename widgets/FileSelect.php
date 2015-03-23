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
use yii\widgets\InputWidget;
use linchpinstudios\filemanager\models\Files;
/**
 * Use this plugin to unobtrusively add a datetimepicker, datepicker or
 * timepicker dropdown to your forms. It's easy to customize options.
 *
 * For example,
 *
 * ```php
 * // a button group using Dropdown widget
 * $form->field($model, 'body')->widget(DateTime::className(), [
 *      'options' => ['rows' => 10],
 *      'clientOptions' => [
 *          'datepicker' => false,
 *          'format' => 'H:i',
 *      ]
 *  ]);
 * ```
 * @see http://xdsoft.net/jqplugins/datetimepicker/
 * @author Josh Hagel <joshhagel@linchpinstudios.com>
 * @since 0.1
 */

 class FileSelect extends InputWidget
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

        $selectOptions = Files::scenario('list')->findAll();

        if ($this->hasModel()) {
            echo Html::activeDropDownList($this->model, $this->attribute, $selectOptions, $this->options);
        } else {
            echo Html::dropDownList($this->name, $this->value, $selectOptions, $this->options);
        }

    }

 }
