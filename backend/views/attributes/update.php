<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SCProductOptionsCategoryes */

$this->title = 'Update Scproduct Options Categoryes: ' . ' ' . $model->categoryID;
$this->params['breadcrumbs'][] = ['label' => 'Scproduct Options Categoryes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->categoryID, 'url' => ['view', 'id' => $model->categoryID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="scproduct-options-categoryes-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
