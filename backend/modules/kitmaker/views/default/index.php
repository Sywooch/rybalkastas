<div class="box">
    <div class="box-header">
        <h3 class="box-title">Комплекты</h3>
    </div>
    <div class="box-body">
        <table class="table table-bordered table-striped dataTable" style="width: 100%">
            <tr>
                <th></th>
                <th>Название комплекта</th>
                <th>Описание</th>
                <th>Содержимое</th>
            </tr>
        <?php foreach($model as $m):?>
            <tr>
                <td><img style="width: 100px" src="/published/publicdata/TESTRYBA/attachments/SC/kits/<?=$m->picture?>" /></td>
                <td><?=$m->name;?></td>
                <td><?=$m->description;?></td>
                <td>
                    <?php foreach($m->elements as $e):?>
                        <div><?=$e->category->name_ru?> - <?=$e->ratio;?> %</div>
                    <?php endforeach;?>
                </td>
            </tr>
        <?php endforeach;?>
        </table>
    </div>
</div>