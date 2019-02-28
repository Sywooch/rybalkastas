<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\SCCategories */

$this->title = 'Create Sccategories';
$this->params['breadcrumbs'][] = ['label' => 'Sccategories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sccategories-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
