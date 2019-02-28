<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title"><a href="<?= \yii\helpers\Url::to(['destination', 'categoryID' => 1]) ?>">Категории</a>
            <?php
            foreach (\common\models\SCCategories::findOne($categoryID)->path as $item) {
                ?>
                > <a href="<?= \yii\helpers\Url::to(['destination', 'categoryID' => $item['id']]) ?>"><?=$item['name']?></a>
                <?php
            }
            ?>

            </h3>

        <div class="box-tools pull-right">
            <?php \yii\widgets\ActiveForm::begin();?>
            <input type="hidden" name="categoryID" value="<?=$categoryID?>"/>
            <button type="submit" class="btn btn-success"><i class="fa fa-play"></i> Выгрузить в текущую папку</button>
            <?php \yii\widgets\ActiveForm::end();?>
        </div>
        <!-- /.box-tools -->
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <?php
        $session = new \yii\web\Session();
        print_r($session['nomenclatureCodes']);
        ?>
        <div class="folder">
            <ol>
                <li style="" class="input-li">
                    <?= yii\helpers\Html::beginForm(['create-category'], 'post', ['data-pjax' => '', 'class' => 'form-inline input-group']);?>
                    <span class="input-group-addon" id="sizing-addon1"><i class="fa fa-folder"></i></span>
                        <input type="text" class="form-control" name="name" placeholder="Создать папку">
                    <input type="hidden" name="parentID" value="<?=$categoryID?>"/>
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="submit">Создать!</button>
                      </span>
                    <?= yii\helpers\Html::endForm();?>
                </li>
                <?php foreach ($model as $m): ?>
                    <li>
                        <a href="<?= \yii\helpers\Url::to(['destination', 'categoryID' => $m->categoryID]) ?>">
                            <i class="fa fa-folder"></i> <?= $m->name_ru ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ol>
        </div>
    </div>
    <!-- /.box-body -->
</div>