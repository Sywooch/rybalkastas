<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 12.04.2017
 * Time: 15:42
 */

$this->title = 'Управление кэшированными страницами';

?>

<div class="box box-danger">
    <div class="box-header with-border">
        <h3 class="box-title">Кэш страниц</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body ">

        <?php
        $count = Yii::$app->dbc->createCommand("SELECT count(*) as count FROM cache")->queryOne()
        ?>

        <?php $form = \yii\widgets\ActiveForm::begin(); ?>
        <?= \yii\helpers\Html::hiddenInput('clear', 1); ?>
        <button type="submit" class="btn btn-warning pull-right">Очистить</button>
        <?php \yii\widgets\ActiveForm::end(); ?>
        Зарегистрировано
        <b><?= $count['count'] ?> <?= MessageFormatter::formatMessage('ru_RU', '{n,plural,=0{записей}=1{запись}one{записей}few{записи}many{записей}other{записей}}', ['n' => $count['count']]) ?> </b>кэша страниц.
        <br/>
        <?php $timePerEntry = 0.000883?>
        <i>Приблизительное время очистки: <?=round($count['count']*$timePerEntry)?> сек.</i>

    </div>

</div>