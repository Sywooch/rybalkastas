<?php
$related = \common\models\SCSameCategories::find()->select('subcategoryID')->where(['categoryID'=> $model->categoryID])->all();
use yii\helpers\Html;
?>
<?php if(!empty($related)):?>
<div class="item-holder catalog-block box-rs">
    <h3>Похожие товары</h3>
    <?php
    $ids = [];
    foreach ($related as $r){
        $ids[] = $r['subcategoryID'];
    }

    $models = \common\models\SCCategories::find()->where(['in','categoryID',$ids])->andWhere(['>','JSON_UNQUOTE(JSON_EXTRACT( meta_data, "$.countInStock"))', 0])->limit(4)->orderBy('RAND()')->all();
    ?>
    <div class="items row-eq-height">
        <?php foreach($models as $m):?>
            <div class="item col-md-3 col-xs-6">
                <div class="item-card">
                    <a href="<?=\yii\helpers\Url::to(['shop/category', 'id'=>$m->categoryID, 'product'=>($m instanceof \common\models\SCProducts?$m->productID:null)])?>" class="name">
                        <div class="img-wrap equal-height-img">
                            <?php if(!empty($m->picture)):?>
                                <?= Html::img(Yii::$app->imageman->load('/products_pictures/'.$m->picture, '250x250', Yii::$app->settings->get('image', 'category'), false, 'categories'), ['alt'=>$m->name_ru])?>
                            <?php else:?>
                                <?= Html::img(Yii::$app->imageman->load('/onDesign.jpg', '250x250', Yii::$app->settings->get('image', 'category'), false, 'common'), ['alt'=>$m->name_ru])?>
                            <?php endif;?>
                        </div>
                        <div class="text-right equal-height-meta">
                            <?php if(isset($m->meta) && $m->meta->minPrice > 0):?>
                                <div class="minprice_label">
                                    от <?=number_format($m->meta->minPrice,2)?> руб.
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
<?php endif;?>