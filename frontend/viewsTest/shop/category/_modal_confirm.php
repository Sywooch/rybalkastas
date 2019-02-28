<?php use yii\helpers\Html;?>

<div class="modal fade addtocart_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">Товар добавлен в корзину</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <img src="<?=Yii::$app->imageman->load('/products_pictures/'.$product->picture, '250x250', Yii::$app->settings->get('image', 'category'), false, 'categories')?>" alt="good"/>
                    </div>
                    <div class="col-md-8">
                        <?=$product->name_ru?>
                        <br/>
                        <i>Арт. <?=$product->product_code?></i>
                        <br/>
                        <i><?=$product->normalActualPrice?> руб. x <?=$count?></i>
                        <hr/>
                        <b class="modal_price"><?=number_format($product->actualPrice*$count,2)?> руб.</b>
                    </div>
                </div>
                <?php
                $related = \common\models\SCRelatedCategories::find()->select('relatedCategoryID')->where(['categoryID'=> $product->categoryID])->limit(4)->orderBy('RAND()')->all();
                ?>
                <div class="text-right">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Продолжить покупки</button>
                    <a href="<?=\yii\helpers\Url::to(['/cart/index'])?>" class="btn btn-primary">Перейти в корзину</a>
                </div>
                <?php if(!empty($related)):?>
                <div class="row">
                    <div class="col-md-12">
                    <h5>С этим товаром покупают:</h5>


                                <div class="item-holder catalog-block box-rs">
                                <?php
                                $ids = [];
                                foreach ($related as $r){
                                    $ids[] = $r['relatedCategoryID'];
                                }

                                $models = \common\models\SCCategories::find()->where(['in','categoryID',$ids])->all();
                                ?>
                                <div class="items row-eq-height">
                                    <?php foreach($models as $m):?>
                                        <div class="item col-md-3 col-xs-6">
                                            <div class="item-card">
                                                <a href="<?=\yii\helpers\Url::to(['shop/category', 'id'=>$m->categoryID, 'product'=>($m instanceof \common\models\SCProducts?$m->productID:null)])?>" class="name">
                                                    <div class="img-wrap equal-height-img">
                                                        <?php if(!empty($m->picture)):?>
                                                            <?= Html::img(Yii::$app->imageman->load('/products_pictures/'.$m->picture, '200x200', Yii::$app->settings->get('image', 'category'), false, 'categories'), ['alt'=>$m->name_ru])?>
                                                        <?php else:?>
                                                            <?= Html::img(Yii::$app->imageman->load('/onDesign.jpg', '200x200', Yii::$app->settings->get('image', 'category'), false, 'common'), ['alt'=>$m->name_ru])?>
                                                        <?php endif;?>
                                                    </div>
                                                    <div class="text-right equal-height-meta">
                                                        <?php if(isset($m->meta) && $m->meta->minPrice > 0):?>
                                                            <div class="minprice_label">
                                                                от <?=number_format($m->meta->minPrice,2)?> руб.
                                                            </div>
                                                        <?php else:?>
                                                            <div class="minprice_label">
                                                                <?=number_format($m->Price,2)?> руб.
                                                            </div>
                                                        <?php endif;?>
                                                    </div>
                                                    <div class="card-label text-center equal-height">
                                                        <?=$m->name_ru?>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    <?php endforeach;?>
                                </div>
                            </div>

                    </div>
                </div>
                <?php endif;?>

            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php
$js = "$('.addtocart_modal').modal('show');";
$this->registerJs($js);
?>