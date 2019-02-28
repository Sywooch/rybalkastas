<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SCExperts */

$this->title = 'Update Scexperts: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Scexperts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->expert_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="scexperts-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
