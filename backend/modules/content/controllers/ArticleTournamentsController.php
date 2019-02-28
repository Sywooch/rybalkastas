<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 07.05.2018
 * Time: 10:24
 */


namespace backend\modules\content\controllers;
use common\models\SCArticlesSponsorship;
use common\models\SCArticlesTournaments;
use Faker\Factory;
use yii\web\Controller;


class ArticleTournamentsController extends Controller
{

    public function actions()
    {
        return [
            'image-upload' => [
                'class' => 'vova07\imperavi\actions\UploadFileAction',
                'url' => 'http://rybalkashop.ru/img/articletournaments/', // Directory URL address, where files are stored.
                'path' => \Yii::getAlias('@frontend/web/img/articletournaments') // Or absolute path to directory where files are stored.
            ],
        ];
    }


    public function actionIndex()
    {
        $model = SCArticlesTournaments::find()->orderBy(['NID'=>SORT_ASC])->all();
        return $this->render('index', ['model'=>$model]);
    }


    public function actionGenerate()
    {
        $faker = Factory::create('ru_RU');
        foreach(range(1, 100) as $index) {
            $model = new SCArticlesSponsorship();
            $model->add_date = $faker->dateTime->format('d.m.Y H:i:s');
            $model->title_ru = $faker->text(32);
            $file = file_get_contents($faker->imageUrl(1000, 1000, null, true,'TEMP'));
            $fname = md5(uniqid().time()).'.jpg';
            $path = '/img/articlesponsors/'.$fname;
            file_put_contents(\Yii::getAlias('@frontend/web/img/articlesponsors/'.$fname), $file);
            $model->picture = $path;
            $model->textToPublication_ru = $faker->text(1200);
            $model->textMini = $faker->text(200);
            $model->created_at = time();
            $model->updated_at = time();
            $model->published_at = time();
            $model->save(false);
        }
    }


}