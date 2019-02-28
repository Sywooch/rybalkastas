<?php

/* @var $this yii\web\View */
/* @var $model common\models\SCReviewTable */

$this->title = 'Обновить обзор: ' . $model->title_ru;

?>

<div class="screview-table-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
