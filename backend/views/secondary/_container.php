<?php foreach($c->links as $l):?>
    <?php $cat = $l->category;?>
    <?php if($l->link_type == 0):?>
        <div style="border: solid 1px #000" class="col-md-3 tile" data-item_id="<?=$l->link_id;?>" data-container_id="<?=$c->id?>" >
            <div data-id="<?=$l->link_id;?>" class="controls">
                <span data-item_id="<?=$l->link_id;?>" class="fa-stack red fa-lg deleteItem">
                  <i class="fa fa-square  fa-stack-2x"></i>
                  <i class="fa fa-times fa-stack-1x fa-inverse"></i>
                </span>
                <span data-item_id="<?=$l->link_id;?>" data-container_id="<?=$l->page_id;?>" data-toggle="modal" class="fa-stack green fa-lg editLink">
                  <i class="fa fa-square  fa-stack-2x"></i>
                  <i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
                </span>
            </div>
            <input type="hidden" id="ls_<?=$l->link_id?>" name="LinkSort[<?=$l->link_id?>]" value="<?=$l->sort_order?>"/>
            <?php
            $name = (!empty($l->custom_name)?$l->custom_name:$cat->name_ru);
            $pic = (!empty($l->custom_image)?$l->custom_image:$cat->picture);
            ?>
            <img style="width: 100%" src="<?=\Yii::$app->urlManagerFrontend->createAbsoluteUrl("/img/products_pictures/$pic");?>"/>
            <div class="text-center">
                <?=$name;?>
            </div>
        </div>
    <?php else:?>
        <div style="border: solid 1px #000" class="col-md-3 tile" data-item_id="<?=$l->link_id;?>" data-container_id="<?=$c->id?>" >
            <div data-id="<?=$l->link_id;?>" class="controls">
                <span data-item_id="<?=$l->link_id;?>" class="fa-stack red fa-lg deleteItem">
                  <i class="fa fa-square  fa-stack-2x"></i>
                  <i class="fa fa-times fa-stack-1x fa-inverse"></i>
                </span>
                <span data-item_id="<?=$l->link_id;?>" data-container_id="<?=$l->page_id;?>" data-toggle="modal" class="fa-stack green fa-lg editLink">
                  <i class="fa fa-square  fa-stack-2x"></i>
                  <i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
                </span>
            </div>
            <input type="hidden" id="ls_<?=$l->link_id?>" name="LinkSort[<?=$l->link_id?>]" value="<?=$l->sort_order?>"/>

            <img style="height: 177px" src="<?=\Yii::$app->urlManagerFrontend->createAbsoluteUrl("/img/products_pictures/$l->custom_image");?>"/>
            <div class="text-center">
                <?=$l->custom_name;?>
            </div>
        </div>
    <?php endif;?>


<?php endforeach;?>

<style>
    .containerContent{
        overflow: auto;
    }
    .tile{
        background: #fff;
        height: 250px;
    }
    .tile .controls{
        position: absolute;
        right: 0;
        top:0;
    }

    .controls .fa-stack{
        cursor: pointer;
    }

    .controls .red{
        color: red;
    }

    .controls .green{
        color: green;
    }
    .controls .fa-stack:hover {
        color: #FFB300;
    }
</style>
