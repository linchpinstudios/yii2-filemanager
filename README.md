Yii2 File Manager
=================
A file manager for Yii2. Allow you to dynamically manager images and files from any location

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist linchpinstudios/yii2-filemanager "*"
```

or add

```
"linchpinstudios/yii2-filemanager": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \linchpinstudios\filemanager\AutoloadExample::widget(); ?>```



```php
<?php
    ......
    'modules' => [
        'filemanager' => [
            'class' => 'linchpinstudios\filemanager\Module',
        ],
    ],
    ......```