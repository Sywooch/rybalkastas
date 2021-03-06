<?php

use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = "Спонсорство";
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="news-page">
    <?php foreach($models as $n):?>
        <div class="col-xs-12">
            <div class="item">
                <div class="col-md-3 col-xs-12">
                    <a href="<?= Url::to(['/sponsorship/item', 'id'=>$n->NID]) ?>">
                        <img src="<?= Yii::$app->imageman->load('/articlesponsors/' . $n->image, null, 30, false, 'articlesponsors') ?>"/>
                    </a>
                </div>
                <div class="col-md-9 col-xs-12">
                    <h4><?= $n->title_ru ?></h4>

                    <div class="caption">
                        <?= substr(rtrim(substr(strip_tags($n->textMini),0,800), "!,.-"), 0, strrpos(rtrim(substr(strip_tags($n->textMini),0,800), "!,.-"), ' ')) ?>...
                    </div>

                    <a class="fslink" href="<?= Url::to(['/sponsorship/item', 'id'=>$n->NID]) ?>"></a>
                </div>

                <div class="more_bn">
                    <a href="<?= Url::to(['/sponsorship/item', 'id'=>$n->NID]) ?>">Читать дальше</a>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    <?php endforeach;?>
</div>

<div class="text-center">
    <?php try {
        echo LinkPager::widget([
            'pagination' => $pages,
        ]);
    } catch (Exception $e) {
        $e->getMessage();
    } ?>
</div>
