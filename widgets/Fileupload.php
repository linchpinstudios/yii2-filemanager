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
 
 class Fileupload extends InputWidget
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
    
        if ($this->hasModel()) {
            echo Html::activeHiddenInput($this->model, $this->attribute, $this->options);
        } else {
            echo Html::hiddenInput($this->name, $this->value, $this->options);
        }
        echo Html::tag('div',Html::a('Select Image',['filemanager/files/filemodal'],['class' => 'btn btn-success','data-toggle' => 'modal','data-target' => '#filePickModal_'.$randomId]));
        
        echo $this->generateModal($randomId);
        //$this->registerClientScript();
    }


    /**
     * Registers CSS and Scripts
     */
    protected function registerClientScript()
    {
        /*$view = $this->getView();

        DateTimePickerAssets::register($view);

        $id = $this->options['id'];

        $options = Json::encode($this->clientOptions);

        $view->registerJs("jQuery('#$id').datetimepicker($options);");*/
    }
    
    
    
    
    protected function generateModal($id)
    {
        $html = '<div class="modal fade" id="filePickModal_'.$id.'">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      ...
                    </div>
                  </div>
                </div>';
                
        return $html;
    }
    
 }