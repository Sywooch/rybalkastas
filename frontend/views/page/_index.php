<?php

/* @var $model \common\models\SCAuxPages */
/* @var $this \yii\web\View */

//init CDEK-widget
if ($model->aux_page_ID == 14) {
    $this->registerJsFile('@web/js/cdek/widjet.js', [
        'position' =>  \yii\web\View::POS_HEAD
    ]);
    $this->registerJsFile('@web/js/cdek/cdek.init.js', [
        'position' => \yii\web\View::POS_END
    ]);
}
//end init CDEK-widget

$js = <<<JS
$('.editpage').click(function(e){
    e.preventDefault();
    $(this).attr('disabled','disabled');
    $.post( $(this).attr('href'), function(data) {
        $("#static_page").html(data);
    });
});
JS;
?>

<?php if (Yii::$app->user->can('contentField')): ?>
    <?php $this->registerJs($js) ?>

    <div class="pull-right">
        <a class="btn btn-flat btn-info editpage"
           href="/shop-admin/render-edit-page?id=<?= $model->aux_page_ID ?>"
           data-toggle="tooltip" title=""
           data-original-title="Редактировать страницу"><i class="fa fa-pencil"></i></a>
    </div>
    <div class="clearfix"></div>
<?php endif;?>

<div class="fancy-title title-dotted-border title-center">
    <h1><?= $model->aux_page_name_ru ?></h1>
</div>

<?= $model->aux_page_text_ru ?>
