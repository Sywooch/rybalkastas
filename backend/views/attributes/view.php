<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\SCProductOptionsCategoryes */

$this->title = $model->categoryID;
$this->params['breadcrumbs'][] = ['label' => 'Scproduct Options Categoryes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="scproduct-options-categoryes-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->categoryID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->categoryID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'categoryID',
            'category_name_en:ntext',
            'category_name_ru:ntext',
            'sort',
        ],
    ]) ?>

</div>
