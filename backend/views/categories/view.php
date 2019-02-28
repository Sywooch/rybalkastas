<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\SCCategories */

$this->title = $model->categoryID;
$this->params['breadcrumbs'][] = ['label' => 'Sccategories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sccategories-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->categoryID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->categoryID], [
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
            'categoryID',
            'parent',
            'products_count',
            'picture',
            'products_count_admin',
            'sort_order',
            'viewed_times:datetime',
            'allow_products_comparison',
            'allow_products_search',
            'show_subcategories_products',
            'name_en',
            'description_en:ntext',
            'meta_title_en',
            'meta_description_en',
            'meta_keywords_en',
            'slug',
            'name_ru',
            'description_ru:ntext',
            'meta_title_ru',
            'meta_description_ru',
            'meta_keywords_ru',
            'vkontakte_type',
            'menutype',
            'id_1c',
            'head_picture',
            'tags:ntext',
            'monufacturer:ntext',
            'menupicture',
            'hidden',
            'add_parents',
            'show_tagsflow',
            'show_monsflow',
            'show_filter',
            'main_sort',
            'showprices',
            'showsubmenu',
            'inbrandname',
            'inbrandpicture',
        ],
    ]) ?>

</div>
