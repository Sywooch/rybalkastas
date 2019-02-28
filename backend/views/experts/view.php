<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\SCExperts */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Scexperts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="scexperts-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->expert_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->expert_id], [
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
            'expert_id',
            'expert_name',
            'expert_last_name',
            'mini_description:ntext',
            'full_text:ntext',
            'picture',
            'title',
            'blog_picture',
            'shop',
            'expert_fullname',
            '1c_id',
            'email:email',
            'is_online',
            'shop_id',
            'sort_order',
            'user_id',
        ],
    ]) ?>

</div>
