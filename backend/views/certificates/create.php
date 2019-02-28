<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\SCCertificates */

$this->title = 'Создать сертификат';
$this->params['breadcrumbs'][] = ['label' => 'Sccertificates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sccertificates-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
