<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\SCExperts */

$this->title = 'Create Scexperts';
$this->params['breadcrumbs'][] = ['label' => 'Scexperts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="scexperts-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
