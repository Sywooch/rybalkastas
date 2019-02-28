<table>
    <?php foreach($products as $p):?>
        <tr>
            <td><?=$p->name_ru;?></td>
            <td><a href="http://rybalkashop.ru/index.php?categoryID=<?=$p->categoryID;?>&product=<?=$p->productID;?>">Перейти на страницу товара</a></td>
        </tr>
    <?php endforeach;?>
</table>