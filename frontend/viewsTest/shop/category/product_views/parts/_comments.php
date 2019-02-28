<?php if(!Yii::$app->user->isGuest && empty(\common\models\SCShopRatings::find()->where(['user_id'=>Yii::$app->user->identity->customer->customerID])->one()) || Yii::$app->user->can('superField')):?>
    <div class="send-review jumbotron">
        <h3>Отправить отзыв</h3>
        <?php $form = \yii\widgets\ActiveForm::begin(['id' => 'form-review']); ?>
        <?= $form->field($rating, 'text')->textarea(['rows'=>10]) ?>
        <div class="row">
            <div class="col-md-5">
                <?= $form->field($rating, 'captcha')->widget(\himiklab\yii2\recaptcha\ReCaptcha::className()) ?>
            </div>
            <div class="col-md-7">
                <?= $form->field($rating, 'stars')->widget(\kartik\rating\StarRating::classname(), [
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

        <?php \yii\widgets\ActiveForm::end(); ?>
    </div>

<?php endif;?>



<?php if(!empty($ratings)):?>
<div class="category">
    <div class="text-center">
        <h1 class="page-header"><?= $this->title ?></h1>
    </div>
    <div class="reviews-list">


        <?php foreach($ratings as $m):?>
            <?php $customer = \common\models\SCCustomers::findOne($m->user_id); ?>
            <?php if(empty($customer)){
            echo $m->user_id;
            continue;
            }?>
            <div class="media">
                <div class="pull-right">
                    <?= \kartik\rating\StarRating::widget([
                        'name' => 'rating_'.$m->rating_id,
                        'value' => $m->rating,
                        'pluginOptions' => ['displayOnly' => true, 'size' => 'xs'],
                        'options'=>['class'=>'text-right']
                    ]);?>
                </div>
                <div class="media-body">

                    <h4 class="media-heading user_name"><?=$customer->first_name?> <?=$customer->last_name?></h4>
                    <?=$m->comment_text?>
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
        'pagination' => $rpages,
    ]);
    ?>
</div>
<?php else:?>
    <p class="text-center">Отзывы отсутствуют</p>
<?php endif;?>
