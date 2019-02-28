<?php echo '<?xml version="1.0" encoding="UTF-8"?>';?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

<?php
$cats = \common\models\SCCategories::getDb()->cache(function ($db) {
    return \common\models\SCCategories::find()->select(['categoryID'])->asArray()->all();
});
?>
    <url>

        <loc>http://rybalkashop.ru</loc>

        <lastmod>2017-07-02</lastmod>

        <changefreq>monthly</changefreq>

        <priority>0.8</priority>

    </url>

    <url>

        <loc>http://rybalkashop.ru/page/o-nas</loc>

        <lastmod>2017-07-02</lastmod>

        <changefreq>monthly</changefreq>

        <priority>0.8</priority>

    </url>

    <url>

        <loc>http://rybalkashop.ru/page/shops</loc>

        <lastmod>2017-07-02</lastmod>

        <changefreq>monthly</changefreq>

        <priority>0.8</priority>

    </url>

    <url>

        <loc>http://rybalkashop.ru/page/kak-zakazat</loc>

        <lastmod>2017-07-02</lastmod>

        <changefreq>monthly</changefreq>

        <priority>0.8</priority>

    </url>

    <url>

        <loc>http://rybalkashop.ru/page/dostavka</loc>

        <lastmod>2017-07-02</lastmod>

        <changefreq>monthly</changefreq>

        <priority>0.8</priority>

    </url>

    <url>

        <loc>http://rybalkashop.ru/page/sposoby-oplaty</loc>

        <lastmod>2017-07-02</lastmod>

        <changefreq>monthly</changefreq>

        <priority>0.8</priority>

    </url>

    <url>

        <loc>http://rybalkashop.ru/page/skidki-i-akcii</loc>

        <lastmod>2017-07-02</lastmod>

        <changefreq>monthly</changefreq>

        <priority>0.8</priority>

    </url>
<?php foreach($cats as $cat):?>
    <url>

        <loc><?=\yii\helpers\Url::to(['shop/category', 'id'=>$cat['categoryID']], true)?></loc>

        <lastmod>2016-09-16</lastmod>

        <changefreq>weekly</changefreq>

        <priority>0.9</priority>

    </url>
<?php endforeach;?>
</urlset>