<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 3/29/2017
 * Time: 3:38 PM
 */

?>

<?php if(Yii::$app->user->can('contentField')):?>
    <div class="pull-right">
        <a class="btn btn-flat btn-info editpage" href="/shop-admin/render-edit-page?id=<?=$model->aux_page_ID?>" data-toggle="tooltip" title="" data-original-title="Редактировать страницу"><i class="fa fa-pencil"></i></a>
    </div>
    <div class="clearfix"></div>
    <?php
    $js = <<< JS

    $('.editpage').click(function(e){
        e.preventDefault();
        $(this).attr('disabled','disabled');
        $.post( $(this).attr('href'), function( data ) {
          $("#static_page").html( data );
        });
    });

JS;
        $this->registerJs($js);
    ?>
<?php endif;?>
<div class="fancy-title title-dotted-border title-center">
    <h1><?= $model->aux_page_name_ru ?></h1>
</div>
<?=$model->aux_page_text_ru?>


