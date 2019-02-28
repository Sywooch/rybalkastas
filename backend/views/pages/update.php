<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SCAuxPages */

$this->title = "Страница ".$model->aux_page_name_ru;

?>
<div class="scaux-pages-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
