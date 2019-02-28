<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\SCNewsTable */
?>
<div class="scnews-table-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'date',
            [
                'label'=>'Привязка к бренду',
                'value'=>$model->brand == 0?'Нет привязки':\common\models\SCMonufacturers::find()->where("id = $model->brand")->one()->name,

            ],
            'title_ru:ntext',
            [
                'label'=>'Картинка',
                'format'=>'raw',
                'value'=>"<img style='width: 75px' src='http://rybalkashop.ru$model->picture'/>"
            ],
            [
                'label'=>'Текст новости',
                'format'=>'raw',
                'value'=>$model->textToPublication_ru
            ],
            [
                'label'=>'Краткий текст',
                'format'=>'raw',
                'value'=>$model->textMini
            ],
        ],
    ]) ?>

</div>
