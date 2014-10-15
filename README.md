Yii2 File Manager
=================
A file manager for Yii2. Allow you to dynamically manager images and files from any location. Also TinyMCE plugin included.


Installation
===============

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



Configure
===============

Add the module to the main configuration.

```
<?php
return [
    //...
    'modules' => [
        //...
        'filemanager' => [
            'class'         => 'linchpinstudios\filemanager\Module',
            'thumbnails'    => [[100,100]],                                              // Optional: array
            'path'          => '/images/uploads/',                                       // Default relative to your web directory or AWS
            'thumbPath'     => '/images/uploads/thumb/',                                 // Default relative to your web directory or AWS
            'aws'           => [
                'enable'        => true,
                'key'           => 'YOURAWS_KEY',
                'secret'        => 'YOURAWS_SECRET',
                'bucket'        => 'your-bucket',
                'url'           => 'http://your-s3-cloudfront-url.com/',                 // either s3 buket URL or CloudFront (can be changed)
            ],
        ],
        //...
    ],
?>
```



Usage
===============

Once the extension is installed, you can access the Module by navigating to http://yourdomain.com/index.php?r=filemanager



Notes
===============

Widget and other items still in development.
