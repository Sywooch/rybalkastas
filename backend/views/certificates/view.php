<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\SCCertificates */

$this->title = $model->certificateID;
$this->params['breadcrumbs'][] = ['label' => 'Sccertificates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sccertificates-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->certificateID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->certificateID], [
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
            'certificateID',
            'certificateNumber',
            'certificateCode',
            'certificateRating',
            'certificateUsed',
        ],
    ]) ?>

</div>
