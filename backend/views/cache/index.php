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
        <h3 class="box-title">Кэш фронтенд данных</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body ">
        <?php $frontEndFiles = \yii\helpers\FileHelper::findFiles(Yii::getAlias('@frontend/runtime/cache')); ?>

        <?php $form = \yii\widgets\ActiveForm::begin(); ?>
        <?= \yii\helpers\Html::hiddenInput('clearFrontend', 1); ?>
        <button type="submit" class="btn btn-warning pull-right">Очистить</button>
        <?php \yii\widgets\ActiveForm::end(); ?>
        Зарегистрировано
        <b><?= count($frontEndFiles) ?> <?= MessageFormatter::formatMessage('ru_RU', '{n,plural,=0{файлов}=1{файл}one{файл}few{файла}many{файлов}other{файлов}}', ['n' => count($frontEndFiles)]) ?> </b>кэша.

    </div>

</div>

<div class="box box-danger">
    <div class="box-header with-border">
        <h3 class="box-title">Кэш бекенд данных</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <?php $backendEndFiles = \yii\helpers\FileHelper::findFiles(Yii::getAlias('@backend/runtime/cache')); ?>

        <?php $form = \yii\widgets\ActiveForm::begin(); ?>
        <?= \yii\helpers\Html::hiddenInput('clearBackend', 1); ?>
        <button type="submit" class="btn btn-warning pull-right">Очистить</button>

        <?php \yii\widgets\ActiveForm::end(); ?>
        Зарегистрировано
        <b><?= count($backendEndFiles) ?> <?= MessageFormatter::formatMessage('ru_RU', '{n,plural,=0{файлов}=1{файл}one{файл}few{файла}many{файлов}other{файлов}}', ['n' => count($backendEndFiles)]) ?> </b>кэша.

    </div>

</div>

<div class="box box-danger">
    <div class="box-header with-border">
        <h3 class="box-title">Кэш изображений</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <?php $imageFiles = \yii\helpers\FileHelper::findFiles(Yii::getAlias('@frontend/web/img/cache')); ?>

        <?php $form = \yii\widgets\ActiveForm::begin(); ?>
        <?= \yii\helpers\Html::hiddenInput('clearImages', 1); ?>
        <button type="submit" class="btn btn-warning pull-right">Очистить</button>

        <?php \yii\widgets\ActiveForm::end(); ?>
        Зарегистрировано
        <b><?= count($imageFiles) ?> <?= MessageFormatter::formatMessage('ru_RU', '{n,plural,=0{файлов}=1{файл}one{файл}few{файла}many{файлов}other{файлов}}', ['n' => count($imageFiles)]) ?> </b>кэша.

    </div>

</div>

