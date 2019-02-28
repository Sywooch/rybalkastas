<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 31.03.2017
 * Time: 14:50
 */




$this->title = "Новости";
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="news-page">
<?php foreach($models as $n):?>
    <div class="col-xs-12">
        <div class="item">
            <div class="col-md-3 col-xs-12">
                <a href="<?=\yii\helpers\Url::to(['/news/item', 'id'=>$n->NID])?>">
                <img src="<?= Yii::$app->imageman->load('/news_pictures/' . $n->image, null, 30, false, 'brandnewss') ?>"/>
                </a>
            </div>
            <div class="col-md-9 col-xs-12">
                <h4><?=$n->title_ru?></h4>
                <div class="caption">
                    <?=substr(rtrim(substr(strip_tags($n->textMini),0,800), "!,.-"), 0, strrpos(rtrim(substr(strip_tags($n->textMini),0,800), "!,.-"), ' '))?>...
                </div>

                <a class="fslink" href="<?=\yii\helpers\Url::to(['/news/item', 'id'=>$n->NID])?>"></a>

                <div class="date"><i class="fa fa-calendar" aria-hidden="true"></i> <?=Yii::$app->formatter->asDate($n->published_at, 'full')?></div>

            </div>
            <div class="more_bn">
                <a href="<?=\yii\helpers\Url::to(['/news/item', 'id'=>$n->NID])?>">Читать дальше</a>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
<?php endforeach;?>
</div>
<div class="text-center">
<?php
echo \yii\widgets\LinkPager::widget([
    'pagination' => $pages,
]);
?>
</div>