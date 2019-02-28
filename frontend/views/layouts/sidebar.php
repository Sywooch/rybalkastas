<?php
use yii\helpers\Html;
use common\models\SCCategories;
use yii\widgets\Menu;
$model = \common\models\SCCategories::find()->where(['parent' => 1])->andWhere('hidden <> 1')->orderBy('sort_order ASC')->all();

/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 4/27/2017
 * Time: 10:07 PM
 */
?>

<?php

$items = [];

$modelAction = \common\models\SCCategories::getDb()->cache(function ($db) {
    return \common\models\SCCategories::find()->where(['parent'=>1])->andWhere('hidden <> 1')->andWhere('JSON_EXTRACT(meta_data, "$.hasAction") = 1')->andWhere('JSON_EXTRACT(meta_data, "$.countActionInStock") > 0')->orderBy('sort_order ASC')->all();
});
$actionItems = [];
foreach ($modelAction as $m){
    $actionItems[] = ['label'=>'<i class="fa fa-percent text-warning" aria-hidden="true"></i> '.$m->name_ru, 'url'=>\yii\helpers\Url::to(['/shop/actions', 'id'=>$m->categoryID])];
}


$items[] = ['label'=>'<img src="/img/icons/discount.svg" style="width: 50px" > Распродажа', 'url'=>['/shop/actions'], 'items'=>$actionItems, 'options'=>['class'=>'dropdown-submenu']];
foreach ($model as $m){
    $menuitem = [];
    $label = '<div class="img-wrap">'.Html::img(Yii::$app->imageman->load('/products_pictures/'.$m->menupicture, '50x50', Yii::$app->settings->get('image', 'sidebarcat'), false, 'sidebar'), ['alt'=>$m->name_ru]).'</div>'.$m->name_ru;
    $menuitem['label'] = $label;
    $menuitem['url'] = \yii\helpers\Url::to(['/shop/category', 'id'=>$m->categoryID]);
    if($m->showsubmenu == 1){
        $menuitem['options'] = ['class'=>'dropdown-submenu'];
        $menuitem['items'] = [];
        $cache = Yii::$app->cache;
        $key = 'sidemenu_inner_'.$m->categoryID;
        $query = $cache->getOrSet($key, function () use ($m) {
            return (new \yii\db\Query())
                ->select('*')
                ->from([\common\models\SCCategories::findWithParents($m->categoryID)])
                ->orderBy('sort_order ASC')->all();
        });

        $submenuitem = [];
        $submenuitem['label'] = '<i class="fa fa-chevron-right"></i> Основной раздел';
        $submenuitem['url'] = \yii\helpers\Url::to(['/shop/category', 'id'=>$m['categoryID']]);
        $menuitem['items'][] = $submenuitem;

        foreach ($query as $cat){
            $submenuitem = [];
            $submenuitem['label'] = '<i class="fa fa-chevron-right"></i> '.$cat['name_ru'];
            $submenuitem['url'] = \yii\helpers\Url::to(['/shop/category', 'id'=>$cat['categoryID']]);
            $menuitem['items'][] = $submenuitem;
        }
    }

    $items[] = $menuitem;
}

?>

<div class="sidebar-good">
    <?=Menu::widget([
        'items'=>$items,
        'activateParents'=>true,
        'submenuTemplate' => "\n<ul class='dropdown-menu'>\n{items}\n</ul>\n",
        'encodeLabels'=>false,
        'options'=> [
            'class'=>'type-good'
        ],
    ]);?>
</div>
<ul class="brand">
    <?php foreach(\common\models\SCSidebarbrands::find()->orderBy('order ASC')->all() as $brand):?>
        <li><a href="<?=$brand->link?>"><?= Html::img(Yii::$app->imageman->load('/brandlogos/JPEG/'.$brand->picture, '270x144', 30, false, 'sidebarbrands'), ['alt'=>$brand->text])?></a></li>
    <?php endforeach;?>
</ul>
<div class="news-sidebar hidden-xs">
    <div class="wrapper">
        <h4>Новости</h4>
        <a href="<?=\yii\helpers\Url::to(['/news/index'])?>" class="look-all">Смотреть все</a>
    </div>
    <?php foreach(\common\models\SCNewsTable::find()->where(['published'=>1])->orderBy('NID DESC')->limit(5)->all() as $n):?>
    <div class="item-card">
        <?= Html::img(Yii::$app->imageman->load('/news_pictures/'.$n->image, '205x205', 60, false, 'sidebarnewss'), ['alt'=>$n->title_ru])?>
        <div class="date"><?=Yii::$app->formatter->asRelativeTime(strtotime($n->add_date));?></div>
        <h2><?=$n->title_ru?></h2>
        <a href="<?=\yii\helpers\Url::to(['/news/item', 'id'=>$n->NID])?>"></a>
    </div>
    <?php endforeach;?>
</div>