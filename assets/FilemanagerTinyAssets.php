<?php
/**
 * @link http://www.linchpinstudios.com/
 * @copyright Copyright (c) 2014 Linchpin Studios LLC
 * @license http://opensource.org/licenses/MIT
 */

namespace linchpinstudios\filemanager\assets;

use yii\web\AssetBundle;

/**
 * Asset bundle for the Twitter bootstrap css files.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class FilemanagerTinyAssets extends AssetBundle
{
    public $sourcePath = '@vendor/linchpinstudios/yii2-filemanager/';
    public $css = [
        /*'css/filemanager.css',*/
    ];
    public $js = [
        'js/filemanager.js',
        'js/filemanagertiny.js',
        'js/filemanager_plugin.js',
    ];
    public $depends = [
        'dosamigos\tinymce\TinyMceAsset',    ];
}
