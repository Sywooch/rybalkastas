<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SCExpertsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Эксперты магазина';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="scexperts-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать эксперта', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'expert_id',
            'expert_name',
            'expert_last_name',
            'mini_description:html',
            'full_text:ntext',
            // 'picture',
            // 'title',
            // 'blog_picture',
            // 'shop',
            // 'expert_fullname',
            // '1c_id',
            // 'email:email',
            // 'is_online',
            // 'shop_id',
            // 'sort_order',
            // 'user_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
