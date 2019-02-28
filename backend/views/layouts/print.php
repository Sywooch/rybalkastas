<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 11.11.2015
 * Time: 13:23
 */
use yii\helpers\Html;
if (class_exists('backend\assets\AppAsset')) {
    backend\assets\AppAsset::register($this);
} else {
    backend\assets\AppAsset::register($this);
}

dmstr\web\AdminLteAsset::register($this);

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="skin-red sidebar-mini">
<?=Yii::$app->alertcomponent->alert();?>
<?php $this->beginBody() ?>

<?= $content;?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>