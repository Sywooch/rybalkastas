<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 12.04.2017
 * Time: 15:42
 */

$this->title = 'Управление кэшированными данными';

?>

<div class="box box-danger">
    <div class="box-header with-border">
        <h3 class="box-title">Кэш данных</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body ">
        <?php $frontEndFiles = \yii\helpers\FileHelper::findFiles(Yii::getAlias('@frontend/runtime/cache')); ?>

        <?php $form = \yii\widgets\ActiveForm::begin(); ?>
        <?= \yii\helpers\Html::hiddenInput('clear', 1); ?>
        <button type="submit" class="btn btn-warning pull-right">Очистить</button>
        <?php \yii\widgets\ActiveForm::end(); ?>
        Зарегистрировано
        <b><?= count($frontEndFiles) ?> <?= MessageFormatter::formatMessage('ru_RU', '{n,plural,=0{файлов}=1{файл}one{файл}few{файла}many{файлов}other{файлов}}', ['n' => count($frontEndFiles)]) ?> </b>кэша.

    </div>

</div>