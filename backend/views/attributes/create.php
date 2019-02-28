<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\SCProductOptionsCategoryes */

$this->title = 'Create Scproduct Options Categoryes';
$this->params['breadcrumbs'][] = ['label' => 'Scproduct Options Categoryes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="scproduct-options-categoryes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
