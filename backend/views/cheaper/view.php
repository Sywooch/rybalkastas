<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\SCFoundCheaper */
?>
<div class="scfound-cheaper-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'customerID',
            'productID',
            'url:url',
        ],
    ]) ?>

</div>
