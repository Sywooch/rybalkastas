<?php
use yii\helpers\Html;
use common\models\SCCategories;
$model = \common\models\SCCategories::getDb()->cache(function ($db) {
    return \common\models\SCCategories::find()->where(['parent'=>1])->andWhere('hidden <> 1')->orderBy('sort_order ASC')->all();
});


?>



<div class="sidebar-good">
    <ul class="type-good">
        <?php foreach($model as $m):?>
            <li class="dropdown-submenu">
                <a href="<?=\yii\helpers\Url::to(['/shop/category', 'id'=>$m->categoryID])?>">
                    <div class="img-wrap">
                        <?= Html::img(Yii::$app->imageman->load('/products_pictures/'.$m->menupicture, '50x50', Yii::$app->settings->get('image', 'sidebarcat'), false, 'sidebar'), ['alt'=>$m->name_ru])?>

                    </div>
                    <?=$m->name_ru?></a>
                <?php if($m->showsubmenu == 1):?>
                    <ul class="dropdown-menu">
                        <?php
                        $cache = Yii::$app->cache;
                        $key = 'sidemenu_inner_'.$m->categoryID;
                        $query = $cache->getOrSet($key, function () use ($m) {
                            return (new \yii\db\Query())
                                ->select('*')
                                ->from([\common\models\SCCategories::findWithParents($m->categoryID)])
                                ->orderBy('sort_order ASC')->all();
                        });

                        ?>
                        <li><a href="<?=\yii\helpers\Url::to(['/shop/category', 'id'=>$m->categoryID])?>"><i class="fa fa-chevron-right"></i> Основной раздел</a></li>

                        <?php foreach($query as $cat):?>
                            <li><a href="<?=\yii\helpers\Url::to(['/shop/category', 'id'=>$cat['categoryID']])?>"><i class="fa fa-chevron-right"></i> <?=$cat['name_ru']?></a></li>
                        <?php endforeach;?>
                    </ul>
                <?php endif;?>
            </li>
        <?php endforeach;?>


    </ul>
</div>
<ul class="brand">
    <?php foreach(\common\models\SCSidebarbrands::find()->orderBy('order ASC')->all() as $brand):?>
        <li><a href="<?=$brand->link?>"><?= Html::img(Yii::$app->imageman->load('/brandlogos/JPEG/'.$brand->picture, '180x96', Yii::$app->settings->get('image', 'sidebarbrand'), false, 'sidebarbrands'), ['alt'=>$brand->text])?></a></li>
    <?php endforeach;?>
</ul>
<div class="news-sidebar hidden-xs">
    <div class="wrapper">
        <h4>Новости</h4>
        <a href="<?=\yii\helpers\Url::to(['/news/index'])?>" class="look-all">Смотреть все</a>
    </div>
    <?php foreach(\common\models\SCNewsTable::find()->orderBy('NID DESC')->limit(5)->all() as $n):?>
        <div class="item-card">
            <?= Html::img(Yii::$app->imageman->load('/news_pictures/'.$n->image, '162x164', Yii::$app->settings->get('image', 'sidebarnews'), false, 'sidebarnews'), ['alt'=>$n->title_ru])?>
            <div class="date"><?=Yii::$app->formatter->asRelativeTime(strtotime($n->add_date));?></div>
            <h2><?=$n->title_ru?></h2>
            <a href="<?=\yii\helpers\Url::to(['/news/item', 'id'=>$n->NID])?>"></a>
        </div>
    <?php endforeach;?>
</div>