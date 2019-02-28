<?php
\frontend\assets\ProductAsset::register($this);
use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>
<div class="editableContent">
    <?php ActiveForm::begin(['action'=>['/shop-admin/submit-edit-product', 'id'=>$model->productID], 'id'=>'productForm'])?>

    <h2 contenteditable="true" class="title editableItem" data-name="SCProducts[name_ru]"><?= $model->name_ru ?></h2>
    <div class="pull-right">
        <button type="button" onclick="cancelEditProduct()" class="btn btn-flat btn-danger cancelEditing" data-toggle="tooltip" title="Отмена"><i class="fa fa-times"></i></button>
        <button type="button" onclick="submitEditProduct()" class="btn btn-flat btn-success cancelEditing" data-toggle="tooltip" title="Сохранить"><i class="fa fa-check"></i></button>
    </div>
    <div class="rating">
        <div class="rat"></div>
    </div>
    <p class="product_code"">Арт: <?= $model->product_code ?></p>
    <div class="row description-card-good">
        <div class="col-md-5 col-sm-5">
            <div class="left-information">
                <div class="img-wrapper">
                    <?php if (isset($model->pictures[0])): ?>
                        <a data-lightbox="productImages" data-title="<?= $model->name_ru ?>" data-pjax="false"
                           href="<?= Yii::$app->imageman->load('/products_pictures/' . $model->pictures[0]->filename, '500x500', 100, 'main', 'products') ?>">
                            <?= Html::img(Yii::$app->imageman->load('/products_pictures/' . $model->pictures[0]->filename, '300x300', 50, false, 'products'), ['alt' => $model->name_ru]) ?>
                        </a>
                    <?php endif; ?>
                </div>
                <div class="img-thumbs text-center">
                    <?php if (isset($model->pictures[1])): ?>
                        <?php foreach ($model->pictures as $k => $pic): ?>
                            <?php if ($k == 0) continue; ?>
                            <div class="col-sm-4">
                                <a data-lightbox="productImages" data-title="<?= $model->name_ru ?>" data-pjax="false"
                                   href="<?= Yii::$app->imageman->load('/products_pictures/' . $pic->filename, '500x500', 100, 'main', 'products') ?>">
                                    <?= Html::img(Yii::$app->imageman->load('/products_pictures/' . $pic->filename, '120x120', 20, false, 'products'), ['alt' => $model->name_ru]) ?>

                                </a>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="clearfix"></div>

            </div>
        </div>
        <div class="col-md-6 col-sm-7 col-md-offset-1">
            <div class="right-information">
                <h3>Характеристики товара</h3>
                <?php
                $attrTarget = $model;
                if (empty($attrTarget->attrs)) {
                    $attrTarget = $model->canon;
                }

                ?>
                <?php if (!empty($attrTarget->attrs)): ?>
                    <?php foreach ($attrTarget->attrs as $attr): ?>
                        <div class="table-good">
                            <span><?= $attr->optionName; ?></span>
                            <strong contenteditable="true" style="min-width:20px;min-height:16px;" class="editableItem" data-name="SCProductOptionsValues[<?=$attr->optionID?>][option_value_ru]"><?= $attr->option_value_ru; ?></strong>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <div class="table-good presence">
                    <span>Наличие</span>
                    <?php if ($model->in_stock > 0): ?>
                        <strong>Есть в наличии</strong>
                    <?php else: ?>
                        <strong class="text-red">Нет в наличии</strong>
                    <?php endif; ?>
                </div>
                <?php if (isset($prependix)): ?>
                    <?= $this->render('addons/' . $prependix, ['model' => $model]) ?>
                <?php endif; ?>
                <div class="wrapper row">
                    <div class="col-md-6 col-sm-12">
                        <div class="price-block">
                            <?php if ($model->list_price > $model->Price): ?>
                                <div class="old"><?= $model->oldPrice ?> руб.</div>
                            <?php endif; ?>
                            <div class="new"><?= $model->normalPrice ?> руб</div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">

                    </div>
                </div>

                <?php if (isset($appendix)): ?>
                    <?= $this->render('addons/' . $appendix, ['model' => $model]) ?>
                <?php endif; ?>
            </div>
        </div>
            <div style="float: left; padding: 15px" contenteditable="true" class="editableItem" data-name="SCProducts[description_ru]">
                <?=$model->description_ru?>
            </div>
            <br/>
    </div>
    <?php ActiveForm::end();?>
</div>

<script>
    function submitEditProduct(){
        $.each($('.editableItem'),  function(){
           $('#productForm').append('<input type="hidden" name="'+$(this).data('name')+'" value="'+$(this).html()+'">');
        });

        $.post( $('#productForm').attr('action'), $('#productForm').serialize(), function( data ) {
            $("#productContainer").html( data );
        });
    }

    function cancelEditProduct(){
        $.post( $('#productForm').attr('action'), $('#productForm').serialize(), function( data ) {
            $("#productContainer").html( data );
        });
    }
</script>

<?php
$js = <<< JS
    
    
JS;
$this->registerJs($js);
?>