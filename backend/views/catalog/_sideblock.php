<?php
$currentCategory = \common\models\SCCategories::findOne($id);
?>

<div data-window="<?=$window?>" data-id="<?=$currentCategory->categoryID?>" class="col-md-6 column">
    <div class="box">

        <div class="box-header">
            <h2 class="box-title"><?=$currentCategory->name_ru?></h2>
            <?php if($currentCategory->parent > 0):?>
            <br/>
            <code>
                <a href="#" class="opencat" data-id="1"> Главная </a>
                <?php foreach($currentCategory->path as $point):?>
                    / <a href="#" class="opencat" data-id="<?=$point['id']?>"> <?=$point['name']?> </a>
                <?php endforeach;?>
            </code>
            <?php endif;?>
        </div>
        <div class="box-body">
            <?php
            \yii\bootstrap\Modal::begin([
                'header' => '<h2>Создать папку</h2><h4>Внутри категории '.$currentCategory->name_ru.'</h4>',
                'toggleButton' => ['class'=>'btn btn-block btn-primary','label' => 'Создать папку'],
            ]);

            echo \yii\helpers\Html::textInput('folderName', null,['class'=>'form-control newFolderName', 'placeholder'=>'Название категории']);
            echo \yii\helpers\Html::a('Создать', '#', ['class'=>'btn btn-success createNewFolder btn-block']);
            \yii\bootstrap\Modal::end();
            ?>
        </div>
        <div class="box-body">
            <ul class="list-group categories">
            <?php foreach ($model as $m):?>
                <li class="list-group-item"><a class="opencat text-bold" data-id="<?=$m->categoryID?>" href="#"><i class="fa fa-folder"></i> <?=$m->name_ru?></a></li>
            <?php endforeach;?>
            </ul>
            <ul class="list-group products">
            <?php foreach ($products as $m):?>
                <li class="list-group-item"><a class="product" data-product="<?=$m->productID?>" href="#"><i class="fa fa-gift"></i> <?=$m->name_ru?></a></li>
            <?php endforeach;?>
            </ul>
        </div>

    </div>
</div>

<style>
    ul.list-group{
        min-height: 20px;
    }
</style>