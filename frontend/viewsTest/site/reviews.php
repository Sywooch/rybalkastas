<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 09.03.2017
 * Time: 12:01
 */

/* @var $model common\models\SCCategories */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $products array */
use kartik\widgets\SwitchInput;
use yii\helpers\Html;
use common\models\SCCustomers;
use kartik\widgets\StarRating;
use yii\widgets\ActiveForm;

$this->title = 'Отзывы о магазине';
$this->params['breadcrumbs'][] = 'Отзывы о магазине';

?>
<?php if(!Yii::$app->user->isGuest || Yii::$app->user->can('superField')):?>
    <div class="send-review jumbotron">
        <h3>Отправить отзыв</h3>
        <?php $form = ActiveForm::begin(['id' => 'form-review']); ?>
        <?= $form->field($rating, 'text')->textarea(['rows'=>10]) ?>
        <div class="row">
            <div class="col-md-5">
                <?= $form->field($rating, 'captcha')->widget(\himiklab\yii2\recaptcha\ReCaptcha::className()) ?>
            </div>
            <div class="col-md-7">
                <?= $form->field($rating, 'stars')->widget(StarRating::classname(), [
                    'pluginOptions' => [
                        'min' => 0,
                        'max' => 5,
                        'step' => 0.5,
                        'size' => 'xs',
                        'language' => 'ru',
                        'defaultCaption' => '{rating} звезд',
                        'starCaptions' => [
                            0 => 'Ни одной звезды',
                            "0.5" => 'Половина звезды',
                            1 => 'Одна звезда',
                            "1.5" => 'Полторы звезды',
                            "2" => 'Две звезды',
                            "2.5" => 'Две с половиной звезды',
                            "3" => 'Три звезды',
                            "3.5" => 'Три с половиной звезды',
                            "4" => 'Четыре звезды',
                            "4.5" => 'Четыре с половиной звезды',
                            "5" => 'Пять звезд',
                        ],
                        'clearCaption' => 'Без оценки',
                        'showClear' => false,
                    ],
                ]);?>
            </div>
        </div>
        <div>
            <button type="submit" class="btn btn-primary btn-flat">Отправить</button>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

<?php endif;?>
<div class="category">
    <div class="text-center">
        <h1 class="page-header"><?= $this->title ?></h1>
    </div>
    <div class="reviews-list">
        <?php foreach($models as $m):?>
        <?php $customer = SCCustomers::findOne($m->user_id); ?>
        <div class="media">
            <div class="pull-right">
                <?= StarRating::widget([
                    'name' => 'rating_'.$m->rating_id,
                    'value' => $m->rating,
                    'pluginOptions' => ['displayOnly' => true, 'size' => 'xs'],
                    'options'=>['class'=>'text-right']
                ]);?>
            </div>
            <div class="media-body">

                <h4 class="media-heading user_name"><?=$customer->first_name?> <?=$customer->last_name?></h4>
                <?=$m->content_text?>
                <p class=""><small><i><?=Yii::$app->formatter->asRelativeTime(strtotime($m->date))?></i></small></p>

            </div>

        </div>
        <?php if(!empty($m->response_text)):?>
            <div class="media response">
                <div class="media-body">
                    <h4 class="media-heading user_name">Ответ администрации</h4>
                    <?=$m->response_text?>
                </div>
            </div>
        <?php endif;?>
        <?php endforeach;?>
    </div>
</div>

<div class="text-center">
    <?php
    echo \yii\widgets\LinkPager::widget([
        'pagination' => $pages,
    ]);
    ?>
</div>