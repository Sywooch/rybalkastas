<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SCCertificates */

$this->title = 'Обновить сертификат: ' . $model->certificateNumber;
$this->params['breadcrumbs'][] = ['label' => 'Сертификаты', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Обновить сертификат';
?>
<div class="sccertificates-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
