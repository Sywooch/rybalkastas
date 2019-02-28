<?php $i=0;?>

<?php foreach($model as $a):?>
    <?php if($i==0):?>
        <input type="hidden" name="attrCat" value="<?=$a->optionCategory;?>"/>
    <?php endif; $i++;?>
    <div class="form-group">
        <label><?=$a->name_ru;?></label>
        <input type="text" name="newAttr[<?=$a->optionID?>]" class="form-control" value="">
    </div>

<?php endforeach;?>


