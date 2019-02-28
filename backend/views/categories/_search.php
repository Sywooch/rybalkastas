<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SCCategoriesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sccategories-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'categoryID') ?>

    <?= $form->field($model, 'parent') ?>

    <?= $form->field($model, 'products_count') ?>

    <?= $form->field($model, 'picture') ?>

    <?= $form->field($model, 'products_count_admin') ?>

    <?php // echo $form->field($model, 'sort_order') ?>

    <?php // echo $form->field($model, 'viewed_times') ?>

    <?php // echo $form->field($model, 'allow_products_comparison') ?>

    <?php // echo $form->field($model, 'allow_products_search') ?>

    <?php // echo $form->field($model, 'show_subcategories_products') ?>

    <?php // echo $form->field($model, 'name_en') ?>

    <?php // echo $form->field($model, 'description_en') ?>

    <?php // echo $form->field($model, 'meta_title_en') ?>

    <?php // echo $form->field($model, 'meta_description_en') ?>

    <?php // echo $form->field($model, 'meta_keywords_en') ?>

    <?php // echo $form->field($model, 'slug') ?>

    <?php // echo $form->field($model, 'name_ru') ?>

    <?php // echo $form->field($model, 'description_ru') ?>

    <?php // echo $form->field($model, 'meta_title_ru') ?>

    <?php // echo $form->field($model, 'meta_description_ru') ?>

    <?php // echo $form->field($model, 'meta_keywords_ru') ?>

    <?php // echo $form->field($model, 'vkontakte_type') ?>

    <?php // echo $form->field($model, 'menutype') ?>

    <?php // echo $form->field($model, 'id_1c') ?>

    <?php // echo $form->field($model, 'head_picture') ?>

    <?php // echo $form->field($model, 'tags') ?>

    <?php // echo $form->field($model, 'monufacturer') ?>

    <?php // echo $form->field($model, 'menupicture') ?>

    <?php // echo $form->field($model, 'hidden') ?>

    <?php // echo $form->field($model, 'add_parents') ?>

    <?php // echo $form->field($model, 'show_tagsflow') ?>

    <?php // echo $form->field($model, 'show_monsflow') ?>

    <?php // echo $form->field($model, 'show_filter') ?>

    <?php // echo $form->field($model, 'main_sort') ?>

    <?php // echo $form->field($model, 'showprices') ?>

    <?php // echo $form->field($model, 'showsubmenu') ?>

    <?php // echo $form->field($model, 'inbrandname') ?>

    <?php // echo $form->field($model, 'inbrandpicture') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
