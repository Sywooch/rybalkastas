<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\SCAuxPages */
?>
<div class="scaux-pages-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'aux_page_slug',
            'aux_page_name_ru',
            'aux_page_text_ru:html',
            'meta_keywords_ru',
            'meta_description_ru:ntext',
        ],
    ]) ?>

</div>
