<?php
/**
 * @link http://www.linchpinstudios.com/
 * @copyright Copyright (c) 2014 Linchpin Studios LLC
 * @license http://opensource.org/licenses/MIT
 */

namespace linchpinstudios\filemanager\widgets;

use Yii;
use linchpinstudios\filemanager\helpers\Html;
use yii\data\Pagination;
use yii\widgets\InputWidget;
use yii\widgets\LinkPager;
use linchpinstudios\filemanager\models\Files;
use linchpinstudios\filemanager\assets\FilemanagerPreactAssets;
/**
 * @see http://xdsoft.net/jqplugins/datetimepicker/
 * @author Josh Hagel <joshhagel@linchpinstudios.com>
 * @since 0.1
 */

 class FilePicker extends InputWidget
 {
    /**
     * @var array the options for the DateTime JS plugin.
     * Please refer to the DateTime JS plugin Web page for possible options.
     * @see http://xdsoft.net/jqplugins/datetimepicker/
     */
    public $clientOptions = [
        'limit'
    ];


    /**
     * run function.
     *
     * @access public
     * @return void
     */
    public function run()
    {
        \Yii::$app->assetManager->forceCopy = true;
        $view = $this->getView();
        FilemanagerPreactAssets::register( $view );

        if ( isset($this->clientOptions['fileTypes']) && !in_array('*', $this->clientOptions['fileTypes']) ) {
            $where = ['type'=>$this->clientOptions['fileTypes']];
        } else {
            $where = [];
        }

        if ($this->hasModel()) {
            $selected = [];
            if (is_array($this->model[$this->attribute])) {
                foreach ($this->model[$this->attribute] as $file) {
                    $selected[] = $file->id;
                }
            } else if (!empty($this->model[$this->attribute])) {
                $selected[] = $this->model[$this->attribute];
            }
        } else {
            $selected = $this->value;
        }

        if ($this->model) {
            $this->name = $this->model->formName() . '[' . $this->attribute .']';
        }

        echo Html::beginTag('div', [
            'data-filemanager' => 'FilePicker',
            'data-target' => $this->name,
            'data-selected' => $selected,
            'data-limit' => isset($this->options['limit']) ? $this->options['limit'] : 0,
        ]);
        echo Html::endTag('div');

    }

 }
