<?php

/* @var $this yii\web\View */
/* @var $model common\models\SCReviewTable */

$this->title = 'Создать обзор';

?>

<div class="screview-table-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
