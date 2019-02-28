<?php echo '<?xml version="1.0" encoding="UTF-8"?>';?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    <?php
    $products = \common\models\SCProducts::getDb()->cache(function ($db) {
        $count = \common\models\SCProducts::find()->count();
        $part = round($count/3);
        $min = $part+$part;
        $max = $part+$part+$part;
        return \common\models\SCProducts::find()->select(['categoryID', 'productID'])->where("productID < $max")->asArray()->all();
    });
    ?>

    <?php foreach($products as $product):?>
        <url>

            <loc><?=str_replace('&', '&amp;',\yii\helpers\Url::to(['shop/category', 'id'=>$product['categoryID'], 'product'=>$product['productID']], true))?></loc>

            <lastmod>2016-09-16</lastmod>

            <changefreq>weekly</changefreq>

            <priority>0.9</priority>

        </url>
    <?php endforeach;?>
</urlset>