<div class="hcol col-md-0">
    <div style="max-height: 150px" class="alert alert-warning alert-dismissible">
        <h4><i class="icon fa fa-warning"></i> Внимание!</h4>
        После сохранения позиции, все старые характеристики (список справа) будут удалены и заменены новыми (список слева).<br>
        Если вы выбрали установку типа товара по ошибке - нажмите кнопку "Отмена" или обновите страницу.

    </div>
    <div class="appenixcontainer">

    </div>
</div>
<div class="ecol col-md-12">
<?php foreach($model->attrs as $a):?>

    <div class="form-group">
        <label><?=$a->optionName;?></label>
        <input type="text" name="setAttr[<?=$a->optionID?>]" class="form-control" value="<?=$a->option_value_ru;?>">
    </div>

<?php endforeach;?>
</div>