<?php
use dosamigos\fileupload\FileUploadUI;


// without UI
$this->title = 'File Upload';
?>


<?= FileUploadUI::widget([
    'model' => $model,
    'attribute' => 'file_name',
    'url' => ['files/upload'], // your url, this is just for demo purposes,
    'options' => ['accept' => 'image/*'],
    'clientOptions' => [
        'maxFileSize' => 2000000
    ]
]);?>
