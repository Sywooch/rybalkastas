<?php
    use dosamigos\fileupload\FileUploadUI;
    use yii\helpers\Url;
$this->title = "Загрузка изображений";
?>


<?= FileUploadUI::widget([
    'name' => 'pic',
    'url' => ['/content/upload/upload'], // your url, this is just for demo purposes,
    'options' => ['accept' => 'image/*'],

    'clientOptions' => [
        'maxFileSize' => 2000000,
        'multiple'=>true,
    ],
    // Also, you can specify jQuery-File-Upload events
    // see: https://github.com/blueimp/jQuery-File-Upload/wiki/Options#processing-callback-options
    'clientEvents' => [
        'fileuploaddone' => 'function(e, data) {
                                console.log(e);
                                console.log(data);

                            }',
        'fileuploadfail' => 'function(e, data) {
                                console.log(e);
                                console.log(data);

                            }',
    ],
]);?>

<style>
    .preview img {
        width: 184px;
    }
</style>
