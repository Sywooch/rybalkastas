<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\SCArticlesSponsorship */
?>
<div class="scarticles-sponsorship-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'NID',
            'add_date',
            'title_en:ntext',
            'title_ru:ntext',
            'picture',
            'textToPublication_en:ntext',
            'textToPublication_ru:ntext',
            'textToMail:ntext',
            'add_stamp',
            'priority',
            'emailed:email',
            'brand',
            'textMini:ntext',
            'textPreview:ntext',
            'published',
            'tpl',
            'created_at',
            'updated_at',
            'published_at',
        ],
    ]) ?>

</div>
