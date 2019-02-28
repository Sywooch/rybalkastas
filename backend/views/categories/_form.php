<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\FileInput;
use kartik\widgets\SwitchInput;
use kartik\widgets\Select2;
use kartik\checkbox\CheckboxX;
use froala\froalaeditor\FroalaEditorWidget;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model \common\models\SCCategories */
/* @var $rootCats \common\models\SCCategories */
/* @var $form yii\widgets\ActiveForm */

?>

<?php Pjax::begin([
    'id' => 'categoryUpdate',
    'enablePushState' => false,
]) ?>

<?php if (Yii::$app->session->hasFlash('success')):
    try {
        echo dmstr\widgets\Alert::widget();
    } catch (Exception $e) {
        $e->getMessage();
    }
endif; ?>

    <div class="sccategories-form">
        <?php $products = Yii::$app->db->createCommand("SELECT tags, name_ru, categoryID FROM SC_categories")->queryAll();

        $tagsarr = array();

        foreach ($products as $prd) {
            $tagsarr[] = $prd['tags'];
        }

        $sep = implode(",", $tagsarr);
        $new = explode(',', $sep);

        $rdy = array();

        foreach($new as $ar){
            $rdy[$ar] = $ar;
        } ?>

        <?php $form = ActiveForm::begin([
            'options' => [
                'enctype' => 'multipart/form-data',
                'data-pjax' => true,
            ]
        ]); ?>

        <div class="row">
            <div class="col-md-10">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Тексты</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body" style="display: block;">
                        <?=$form->field($model,'name_ru');?>

                        <?=$form->field($model,'name_extended');?>

                        <label class="control-label" for="sccategories-name_extended">Описание</label>
                        <?php try {
                            echo FroalaEditorWidget::widget([
                                'model' => $model,
                                'attribute' => 'description_ru',
                                'options' => [
                                    'id' => 'content'
                                ],
                                'clientOptions' => [
                                    'toolbarInline' => false,
                                    'theme' => 'royal',
                                    //'height' => 100,
                                    'language' => 'ru',
                                    'toolbarButtons' => ['undo', 'redo', '|', 'fullscreen', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'outdent', 'indent', 'clearFormatting', 'insertTable', '|', 'html', 'paragraphFormat', 'insertImage', 'code'],
                                    'imageUploadParam' => 'file',
                                    'imageUploadURL' => \yii\helpers\Url::to(['pages/upload/'])
                                ],
                            ]);
                        } catch (Exception $e) {
                            echo $e->getMessage();
                        } ?>

                        <br/>

                        <label class="control-label" for="sccategories-name_extended">Контент под шапкой</label>
                        <?php try {
                            echo FroalaEditorWidget::widget([
                                'model' => $model,
                                'attribute' => 'subheader',
                                'options' => [
                                    'id' => 'content_sub'
                                ],
                                'clientOptions' => [
                                    'toolbarInline' => false,
                                    'theme' => 'royal',
                                    //'height' => 100,
                                    'language' => 'ru',
                                    'toolbarButtons' => ['undo', 'redo', '|', 'fullscreen', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'outdent', 'indent', 'clearFormatting', 'insertTable', '|', 'html', 'paragraphFormat', 'insertImage', 'code'],
                                    'imageUploadParam' => 'file',
                                    'imageUploadURL' => \yii\helpers\Url::to(['pages/upload/'])
                                ],
                            ]);
                        } catch (Exception $e) {
                            echo $e->getMessage();
                        } ?>

                        <div style="margin: 20px 0">
                            <label class="control-label">Родитель</label>
                            <?= $this->render('_select_parent', [
                                'val' => $model->parent
                            ]) ?>
                        </div>

                        <?=$form->field($model,'meta_title_ru');?>

                        <?=$form->field($model,'meta_keywords_ru');?>

                        <?=$form->field($model,'na_message');?>

                        <?php //$form->field($model,'meta_description_ru');?>
                    </div>
                </div>

                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Картинки</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body" style="display: block;">
                        <div class="row">
                            <div class="col-md-12">
                                <?= $form->field($model, 'picture')->widget(FileInput::classname(), [
                                    'options' => ['accept' => 'image/*'],
                                    'pluginOptions' => [
                                        'initialPreview' => [
                                            Html::img(\Yii::$app->urlManagerFrontend->createAbsoluteUrl("/img/products_pictures/$model->picture"), ['class' => 'file-preview-image', 'alt' => $model->picture, 'title' => $model->picture]),
                                        ],
                                        'initialCaption' => $model->picture,
                                        'overwriteInitial' => true,
                                        'showRemove' => true,
                                        'showUpload' => false,
                                        'browseLabel' => 'Загрузить'
                                    ]
                                ]); ?>

                                <?= $form->field($model, 'head_picture')->widget(FileInput::classname(), [
                                    'options' => ['accept' => 'image/*'],
                                    'pluginOptions' => [
                                        'initialPreview' => !empty($model->head_picture) ? [
                                            Html::img(\Yii::$app->urlManagerFrontend->createAbsoluteUrl("/img/products_pictures/$model->head_picture"), ['class' => 'file-preview-image', 'alt' => $model->head_picture, 'title' => $model->head_picture]),
                                        ] : false,
                                        'initialCaption' => $model->head_picture,
                                        'overwriteInitial' => true,
                                        'showRemove' => true,
                                        'showUpload' => false,
                                        'browseLabel' => 'Загрузить'
                                    ]
                                ]); ?>

                                <?php if ($model->parent == 1) : ?>
                                    <?= $form->field($model, 'menupicture')->widget(FileInput::classname(), [
                                        'options' => ['accept' => 'image/*'],
                                        'pluginOptions' => [
                                            'initialPreview' => !empty($model->menupicture) ? [
                                                Html::img(\Yii::$app->urlManagerFrontend->createAbsoluteUrl("/img/products_pictures/$model->menupicture"), ['class' => 'file-preview-image', 'alt' => $model->menupicture, 'title' => $model->menupicture]),
                                            ] : false,
                                            'initialCaption' => $model->menupicture,
                                            'overwriteInitial' => true,
                                            'showRemove' => false,
                                            'showUpload' => false,
                                            'browseLabel' => 'Загрузить'
                                        ]
                                    ]); ?>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Переключатели</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body" style="display: block;">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="col-md-4">
                                    <?= $form->field($model, 'show_tagsflow')->widget(SwitchInput::classname(),[
                                        'pluginOptions' => [
                                            'onText' => 'Да',
                                            'offText' => 'Нет'
                                        ]
                                    ]); ?>
                                </div>
                                <div class="col-md-4">
                                    <?= $form->field($model, 'show_monsflow')->widget(SwitchInput::classname(),[
                                        'pluginOptions' => [
                                            'onText' => 'Да',
                                            'offText' => 'Нет'
                                        ]
                                    ]); ?>
                                </div>
                                <div class="col-md-4">
                                    <?= $form->field($model, 'show_catsflow')->widget(SwitchInput::classname(),[
                                        'pluginOptions' => [
                                            'onText' => 'Да',
                                            'offText' => 'Нет'
                                        ]
                                    ]); ?>
                                </div>
                                <div class="col-md-4">
                                    <?= $form->field($model, 'show_filter')->widget(SwitchInput::classname(),[
                                        'pluginOptions' => [
                                            'onText' => 'Да',
                                            'offText' => 'Нет'
                                        ]
                                    ]); ?>
                                </div>
                                <div class="col-md-4">
                                    <?= $form->field($model, 'hidden')->widget(SwitchInput::classname(),[
                                        'pluginOptions' => [
                                            'onText' => 'Да',
                                            'offText' => 'Нет'
                                        ]
                                    ]); ?>
                                </div>
                                <div class="col-md-4">
                                    <?= $form->field($model, 'showprices')->widget(SwitchInput::classname(),[
                                        'pluginOptions' => [
                                            'onText' => 'Да',
                                            'offText' => 'Нет'
                                        ]
                                    ]); ?>
                                </div>

                                <div class="col-md-12 text-right">
                                    <hr>

                                    <a class="btn btn-app" id="setNew" data-id="<?= $model->categoryID; ?>">
                                        <i class="fa fa-edit"></i> Установить NEW
                                    </a>
                                    <a class="btn btn-app" id="unsetNew" data-id="<?= $model->categoryID; ?>">
                                        <i class="fa fa-edit"></i> Удалить NEW
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <?= $form->field($model, 'monufacturer')->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map(\common\models\SCMonufacturers::find()->all(), 'name', 'name'),
                                    'options' => ['placeholder' => 'Выбрать производителя'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);?>

                                <?= $form->field($model, 'menutype')->widget(Select2::classname(), [
                                    'data' => ['0' => 'Категория', '1' => 'Таблица', '2' => 'Миниатюры', '3' => 'Одежда', '4' => 'Катера', '5' => 'Миниатюры с вкладками', '6' => 'Один товар'],
                                    'options' => ['placeholder' => 'Выбрать производителя'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);?>

                                <?= $form->field($model, 'sort_type')->widget(Select2::classname(), [
                                    'data' => ['default' => 'По дефолту', 'asc' => 'По возрастанию', 'desc' => 'По убыванию'],
                                    'options' => ['placeholder' => 'Выбрать тип'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);?>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-12">
                                <?= $form->field($model, 'tagar')->widget(Select2::classname(), [
                                    'data' => $rdy,
                                    'options' => ['placeholder' => 'Выбрать теги', 'multiple' => true],
                                    'pluginOptions' => [
                                        'tags' => true,
                                        'maximumInputLength' => 255
                                    ],
                                ]);?>
                            </div>

                            <div class="col-md-12">
                                <hr>

                                <?php if (!empty($model->hasProducts)): ?>
                                    <!-- Related -->
                                    <div class="col-md-3 text-center">
                                        <label class="control-label">Сопутствующие товары</label>

                                        <br/>

                                        <?php Modal::begin([
                                            'header' => '<h2>Выбрать сопутствующие товары</h2>',
                                            'size' => 'modal-lg',
                                            'toggleButton' => [
                                                'label' => 'Выбрать',
                                                'class' => 'btn btn-success'
                                            ],
                                        ]); ?>

                                        <div class="cattreemain" data-template="modaltreeProducts" data-type="related">
                                            <?= $this->render('modaltreeProducts', [
                                                'rootCats' => $rootCats,
                                                'static'   => 1,
                                                //'treeId'   => 1,
                                                'type'     => 'related',
                                                'main'     => $main
                                            ]); ?>
                                        </div>

                                        <?php Modal::end(); ?>

                                        <hr>

                                        <?php if (!empty($model->related)): ?>
                                            <label class="control-label">Установленные:</label>
                                            <ul class="sublist">
                                                <?php foreach ($model->related as $rel): ?>
                                                    <li>
                                                        <span><?= $rel->name_ru; ?></span>
                                                        <input type="hidden" name="relatedset[<?= $rel->categoryID ?>]" value="0"/>
                                                        <?php try {
                                                            echo CheckboxX::widget([
                                                                'name' => 'relatedset[' . $rel->categoryID . ']',
                                                                'initInputType' => CheckboxX::INPUT_CHECKBOX,
                                                                'value' => 1,
                                                                'pluginOptions' => [
                                                                    'size' => 'sm',
                                                                    'threeState' => false,
                                                                    'iconChecked' => '<b>&check;</b>',
                                                                    'iconUnchecked' => '<b style="color:red"><i class="fa fa-times"><i></b>',
                                                                ],
                                                            ]);
                                                        } catch (Exception $e) {
                                                            echo $e->getMessage();
                                                        } ?>
                                                    </li>
                                                <?php endforeach;?>
                                            </ul>
                                        <?php endif;?>
                                    </div> <!-- // Related -->

                                    <?php if (Yii::$app->user->can('superField')): ?>
                                        <!-- self Related -->
                                        <div class="col-md-3 text-center">
                                            <label class="control-label">Разместить как сопутствующий</label>

                                            <br/>

                                            <?php Modal::begin([
                                                'header' => '<h2>Выбрать товар для размещения</h2>',
                                                'size' => 'modal-lg',
                                                'toggleButton' => [
                                                    'label' => 'Выбрать',
                                                    'class' => 'btn btn-success'
                                                ],
                                            ]); ?>

                                            <div class="cattreemain" data-template="modaltreeProducts" data-type="selfrelated">
                                                <?= $this->render('modaltreeProducts', [
                                                    'rootCats' => $rootCats,
                                                    'static'   => 1,
                                                    //'treeId'   => 1,
                                                    'type'     => 'selfrelated',
                                                    'main'     => $main
                                                ]); ?>
                                            </div>

                                            <?php Modal::end(); ?>

                                            <hr>

                                            <?php if (!empty($model->selfRelated)): ?>
                                                <label class="control-label">Размещен в:</label>
                                                <ul class="sublist">
                                                    <?php foreach ($model->selfRelated as $sRel): ?>
                                                        <li>
                                                            <span><?= $sRel->name_ru; ?></span>
                                                            <input type="hidden" name="selfrelatedset[<?= $sRel->categoryID ?>]" value="0"/>
                                                            <?php try {
                                                                echo CheckboxX::widget([
                                                                    'name' => 'selfrelatedset[' . $sRel->categoryID . ']',
                                                                    'initInputType' => CheckboxX::INPUT_CHECKBOX,
                                                                    'value' => 1,
                                                                    'pluginOptions' => [
                                                                        'size' => 'sm',
                                                                        'threeState' => false,
                                                                        'iconChecked' => '<b>&check;</b>',
                                                                        'iconUnchecked' => '<b style="color:red"><i class="fa fa-times"><i></b>',
                                                                    ],
                                                                ]);
                                                            } catch (Exception $e) {
                                                                echo $e->getMessage();
                                                            } ?>
                                                        </li>
                                                    <?php endforeach;?>
                                                </ul>
                                            <?php endif;?>
                                        </div><!-- // self Related -->
                                    <?php endif; ?>

                                    <!-- Same -->
                                    <div class="col-md-3 text-center border-left">
                                        <label class="control-label">Похожие товары</label>

                                        <br/>

                                        <?php Modal::begin([
                                            'header' => '<h2>Похожие товары</h2>',
                                            'size' => 'modal-lg',
                                            'toggleButton' => [
                                                'label' => 'Выбрать',
                                                'class' =>'btn btn-success'
                                            ],
                                        ]); ?>

                                        <div class="cattreemain" data-template="modaltreeProducts" data-type="same">
                                            <?= $this->render('modaltreeProducts', [
                                                'rootCats' => $rootCats,
                                                'static' => 1,
                                                //'treeId' => 1,
                                                'type' => 'same',
                                                'main' => $main
                                            ]); ?>
                                        </div>

                                        <?php Modal::end(); ?>

                                        <hr>

                                        <?php if (!empty($model->same)): ?>
                                            <label class="control-label">Установленные:</label>
                                            <ul class="sublist">
                                                <?php foreach ($model->same as $s):?>
                                                    <li>
                                                        <span><?= $s->name_ru; ?></span>
                                                        <input type="hidden" name="sameset[<?= $s->categoryID ?>]" value="0"/>
                                                        <?php try {
                                                            echo CheckboxX::widget([
                                                                'name' => 'sameset[' . $s->categoryID . ']',
                                                                'initInputType' => CheckboxX::INPUT_CHECKBOX,
                                                                'value' => 1,
                                                                'pluginOptions' => [
                                                                    'size' => 'sm',
                                                                    'threeState' => false,
                                                                    'iconChecked' => '<b>&check;</b>',
                                                                    'iconUnchecked' => '<b style="color:red"><i class="fa fa-times"><i></b>',
                                                                ],
                                                            ]);
                                                        } catch (Exception $e) {
                                                            echo $e->getMessage();
                                                        } ?>
                                                    </li>
                                                <?php endforeach;?>
                                            </ul>
                                        <?php endif;?>
                                    </div> <!-- // Same -->
                                <?php endif;?>

                                <!-- Parents -->
                                <div class="col-md-3 text-center border-left">
                                    <label class="control-label">Доп. родители</label>

                                    <br/>

                                    <?php Modal::begin([
                                        'header' => '<h2>Выбрать родителей</h2>',
                                        'toggleButton' => [
                                            'label' => 'Выбрать',
                                            'class'=>'btn btn-success'
                                        ],
                                    ]); ?>

                                    <div class="cattreemain" data-template="modaltree" data-type="parents">
                                        <?= $this->render('modaltree', [
                                            'rootCats' => $rootCats,
                                            'static' => 1,
                                            //'treeId' => 1,
                                            'type' => 'parents',
                                            'main' => $main
                                        ]); ?>
                                    </div>

                                    <?php Modal::end(); ?>

                                    <hr>

                                    <?php if (!empty($model->parentss)): ?>
                                        <label class="control-label">Родительские категории:</label>
                                        <ul class="sublist">
                                            <?php foreach ($model->parentss as $parent): ?>
                                                <li>
                                                    <span><?= $parent->name_ru; ?></span>
                                                    <input type="hidden" name="parentset[<?= $parent->categoryID ?>]" value="0"/>
                                                    <?php try {
                                                        echo CheckboxX::widget([
                                                            'name' => 'parentset[' . $parent->categoryID . ']',
                                                            'initInputType' => CheckboxX::INPUT_CHECKBOX,
                                                            'value' => 1,
                                                            'pluginOptions' => [
                                                                'size' => 'sm',
                                                                'threeState' => false,
                                                                'iconChecked' => '<b>&check;</b>',
                                                                'iconUnchecked' => '<b style="color:red"><i class="fa fa-times"><i> </b>',
                                                            ],
                                                        ]);
                                                    } catch (Exception $e) {
                                                        echo $e->getMessage();
                                                    } ?>
                                                </li>
                                            <?php endforeach;?>
                                        </ul>
                                    <?php endif;?>
                                </div> <!-- // Parents -->

                                <!-- Childs -->
                                <?php if (!$model->hasProducts): ?>
                                    <div class="col-md-3 text-center border-left">
                                        <label class="control-label">Доп. дочери</label>

                                        <br/>

                                        <?php Modal::begin([
                                            'header' => '<h2>Выбрать дочерей</h2>',
                                            'toggleButton' => [
                                                'label' => 'Выбрать',
                                                'class' => 'btn btn-warning'
                                            ],
                                        ]); ?>

                                        <div class="cattreemain" data-template="modaltree" data-type="childs">
                                            <?= $this->render('modaltree', [
                                                'rootCats' => $rootCats,
                                                'static' => 1,
                                                //'treeId' => 1,
                                                'type' => 'childs',
                                                'main' => $main
                                            ]); ?>
                                        </div>

                                        <?php Modal::end(); ?>

                                        <hr>

                                        <?php if (!empty($model->childs)): ?>
                                            <label class="control-label">Дочерние категории:</label>
                                            <ul class="sublist">
                                                <?php foreach ($model->childs as $child): ?>
                                                    <li>
                                                        <span><?= $child->name_ru; ?></span>
                                                        <input type="hidden" name="childset[<?= $child->categoryID ?>]" value="0"/>
                                                        <?php try {
                                                            echo CheckboxX::widget([
                                                                'name' => 'childset[' . $child->categoryID . ']',
                                                                'initInputType' => CheckboxX::INPUT_CHECKBOX,
                                                                'value' => 1,
                                                                'pluginOptions' => [
                                                                    'size' => 'sm',
                                                                    'threeState' => false,
                                                                    'iconChecked' => '<b>&check;</b>',
                                                                    'iconUnchecked' => '<b style="color:red"><i class="fa fa-times"><i> </b>',
                                                                ],
                                                            ]);
                                                        } catch (Exception $e) {
                                                            $e->getMessage();
                                                        } ?>
                                                    </li>
                                                <?php endforeach;?>
                                            </ul>
                                        <?php endif;?>
                                    </div> <!-- // Childs -->
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Сохранить', [
                        'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
                        'data-pjax' => 1,
                    ]) ?>
                </div>
            </div>

            <div class="col-md-2">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Ближайшие категории</h3>
                    </div>
                    <div class="box-body">
                        <ul class="products-list product-list-in-box">
                            <?php foreach ($nearCats as $cat): ?>
                                <li class="item">
                                    <div class="product-img">
                                        <img style="width: 50px" src="<?= \Yii::$app->urlManagerFrontend->createAbsoluteUrl("/img/products_pictures/$cat->picture") ?>" alt="<?= $cat->name_ru ?>">
                                    </div>

                                    <div class="product-info">
                                        <a href="<?= Url::toRoute(['/categories/update', 'id' => $cat->categoryID])?>" class="product-title"><?= $cat->name_ru ?></a>
                                        <span class="product-description">
                                            <a href="<?= Url::toRoute(['/categories/update', 'id' => $cat->categoryID]) ?>"><i>Редактировать</i></a>
                                        </span>
                                    </div>
                                </li>
                            <?php endforeach;?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

<?php Pjax::end(); ?>

<?php

$urlset = Url::to(['categories/set-new']);
$urlunset = Url::to(['categories/unset-new']);

$js = <<< JS
    $(function(){
        $('#setNew').click(function(){
            var id = $(this).data('id');
            
            $.post( "$urlset&id=" + id, function(data) {
              alert('маркер NEW установлен')
            });
        });

        $('#unsetNew').click(function(){
            var id = $(this).data('id');
            
            $.post( "$urlunset&id=" + id, function(data) {
              alert('маркер NEW удален')
            });
        });

        $('.fileinput-remove').click(function() {
            \$name = $(this).closest('.form-group').find("input[type=hidden]").attr('name');
            $(this).closest('.form-group').append('<input class="deletesign" type="hidden" name="'+\$name+'" value="TODELETE"/>')
        });

        $('input[type=file]').change(function(){
            $(this).closest('.form-group').find('.deletesign').remove();
        });
    });
JS;
$this->registerJs($js);

?>
