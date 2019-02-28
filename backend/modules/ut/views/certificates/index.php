<input type="text" class="form-control" id="numInput" onkeyup="myFunction()" placeholder="Найти по коду">
<table id="certTable" class="table table-striped table-hover">
    <tr>
        <th>Номер</th>
        <th>Код номенклатуры</th>
        <th>Номинал</th>
        <th>Использован</th>
        <th>Использован на сайте</th>
        <th>Код проверки</th>
        <th></th>
    </tr>
    <?php $rateToNum = [];?>
    <?php foreach($certs as $ar):?>
        <?php
        $rateToNum[$ar->rating] = $ar->name;
        $model = \common\models\SCCertificates::find()->where(['certificateNumber'=>$ar->number])->one();
        ?>
        <tr data-charcode="<?=$ar->charCode?>">
            <td>
                <?=$ar->number?>
            </td>
            <td>
                <?=$ar->name?>
            </td>
            <td>
                <?=$ar->rating?>
            </td>
            <td>
                <?php if($ar->used == 1):?>
                    <b class="text-danger"> Использован</b>
                <?php else:?>
                    <b class="text-success"> Не использован</b>
                <?php endif;?>
            </td>
            <td>
                <?php if(!empty($model)):?>
                    <?php if($model->certificateUsed == 1):?>
                        <b class="text-danger"> Использован</b>
                    <?php else:?>
                        <b class="text-success"> Не использован</b>
                    <?php endif;?>
                <?php endif;?>
            </td>
            <td>
                <?php
                if(!empty($model)){
                    echo $model->certificateCode;
                }
                ?>
            </td>
            <td>
                <a href="#" class="btn btn-success btn-sm">Обновить</a>
            </td>
        </tr>
    <?php endforeach;?>
</table>

<?php foreach($rateToNum as $k=>$rn):?>
    <div class="hidden rate_<?=$k?>"><?=$rn?></div>
<?php endforeach;?>

<script>
    function myFunction() {
        // Declare variables
        var input, filter, table, tr, td, i;
        input = document.getElementById("numInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("certTable");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>