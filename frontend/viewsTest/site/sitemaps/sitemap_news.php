<?php echo '<?xml version="1.0" encoding="UTF-8"?>';?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

<?php
$news = \common\models\SCNewsTable::getDb()->cache(function ($db) {
    return \common\models\SCNewsTable::find()->all();
});
?>

<?php foreach($news as $newsitem):?>
    <url>

        <loc><?=\yii\helpers\Url::to(['news/item', 'id' => $newsitem['NID']], true)?></loc>

        <lastmod>2016-09-16</lastmod>

        <changefreq>weekly</changefreq>

        <priority>1</priority>

    </url>
<?php endforeach;?>
</urlset>