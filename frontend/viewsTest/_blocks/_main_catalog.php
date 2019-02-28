<?php
$model = \common\models\SCCategories::find()->where(['parent'=>1])->andWhere('hidden <> 1')->orderBy('main_sort ASC')->all();
use yii\helpers\Html;
?>

<div class="catalog-block">
    <h4>Каталог</h4>
    <div class="item-holder">
        <div class="row text-center">
            <?php foreach ($model as $m):?>
                <div class="item col-md-3 col-xs-6">
                    <div class="item-card">
                        <a href="<?=\yii\helpers\Url::to(['shop/category', 'id'=>$m->categoryID])?>" class="name">
                            <div class="img-wrap">
                                <?= Html::img(Yii::$app->imageman->load('/products_pictures/'.$m->picture, '250x250', Yii::$app->settings->get('image', 'category'), false, 'categories'), ['alt'=>$m->name_ru])?>
                            </div>
                            <div class="card-label equal-height">
                                <?=$m->name_ru?>
                            </div>
                        </a>
                    </div>
                </div>
                <?php /*if($m->categoryID == 444){
                   echo $this->render('__d_primanki');
                }*/?>
            <?php endforeach;?>
        </div>
    </div>
</div>