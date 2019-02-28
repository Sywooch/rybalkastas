<?php
$string = $model->description_ru;
?>

<?php if(!empty($string)):?>
    <div class="box box-primary item-holder catalog-block box-rs" id="productDescription">
        <div class="box-header">
            <h3>Описание <?=$model->name_ru?></h3>
        </div>
        <div class="box-body">
            <div class="col-md-12">
                <?=$string?>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
<?php endif;?>



