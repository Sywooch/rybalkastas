<?php
$model = \common\models\SCProductOptionsCategoryes::find()->orderBy("category_name_ru")->all();
?>
<div class="cattreemain">
    <ul class="catlist">
    <?php foreach($model as $cat): ?>
        <li>
            <a class="btn btn-xs setnewoptions" data-dismiss="modal" data-catid="<?=$cat->categoryID;?>" style="
            float: right;
            ">
            <i class="fa fa-play"></i> Присвоить
            </a>
            <span><?=$cat->category_name_ru?></span>

        </li>
    <?php endforeach;?>
    </ul>
</div>

<style>
    .cattreemain ul:not(.dropdown-menu) > li {
        display: block;
        padding: 10px;
        margin-left: 5px;
        background: #fff;
        border: solid 1px #ECF0F5;
        cursor: pointer;
        position: relative;
    }

    .cattreemain .sub{
        display: none;
    }

    .cattreemain i {
        margin-right: 10px;
        float: left;
        font-size: 142%;
    }

    .cattreemain span{
        display: block;
    }

    .cattreemain ul{
        padding:0;
    }

    .prdtreemain {
        position: relative;
    }
    .prdtreemain ul:not(.dropdown-menu) > li {
        display: block;
        padding: 10px;
        margin-left: 5px;
        background: #fff;
        border: solid 1px #ECF0F5;
        cursor: pointer;
        position: relative;
    }

    .prdtreemain li.highlight {
        background: #C9CBFF;
    }

    .cattreemain li.highlight {
        background: #c1ffd3;
    }

    .prdtreemain i {
        margin-right: 10px;
    }

    .prdtreemain ul{
        padding:0;
    }

    .preloader {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        text-align: center;
        background-color: rgba(139, 139, 139, 0.58);
    }

    .preloader i {
        line-height: 40px;
    }

    .cattreemain ul:not(.dropdown-menu) > div > li.selected {
        background-color: #D8DBFF;
    }
</style>


