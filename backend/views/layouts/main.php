<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */


if (Yii::$app->controller->action->id === 'login') { 
/**
 * Do not use this code in your template. Remove it. 
 * Instead, use the code  $this->layout = '//main-login'; in your controller.
 */
    echo $this->render(
        'main-login',
        ['content' => $content]
    );
} else {

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
        <meta name="uid" content="<?=base64_encode(Yii::$app->user->id.Yii::$app->params['chat_secret']);?>"?>
    </head>
    <body class="sidebar-mini skin-purple-light">
    <?=Yii::$app->alertcomponent->alert();?>
    <?php $this->beginBody() ?>
    <div class="wrapper">

        <?= $this->render(
            'header.php',
            ['directoryAsset' => $directoryAsset]
        ) ?>

        <?= $this->render(
            'left.php',
            ['directoryAsset' => $directoryAsset]
        )
        ?>

        <?= $this->render(
            'content.php',
            ['content' => $content, 'directoryAsset' => $directoryAsset]
        ) ?>
        <aside class="control-sidebar control-sidebar-dark">
            <div class="col-md-12">
                <h4>Онлайн</h4>
                <ul class="control-sidebar-menu" id="users-online">

                </ul>
            </div>

        </aside>
        <div class="control-sidebar-bg"></div>
    </div>

    <?php $this->endBody() ?>
    <style>
        section.content::after {
            content: "";
            display: block;
            clear: both;
        }
    </style>
    </body>
    </html>
    <?php $this->endPage() ?>
<?php } ?>
