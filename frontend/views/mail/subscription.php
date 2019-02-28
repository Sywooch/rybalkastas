<div style="padding: 10px">
<table style="width: 100%;margin-top: 40px;margin-bottom: 40px">
    <tr>
        <th style="border: solid 1px #c2c2c2;font-weight: bold;">Имя пользователя</th>
        <th style="border: solid 1px #c2c2c2;font-weight: bold;">Номер телефона</th>
        <th style="border: solid 1px #c2c2c2;font-weight: bold;">Товар</th>
        <th style="border: solid 1px #c2c2c2;font-weight: bold;">Код товара</th>
    </tr>
    <tr>
        <td style="border: solid 1px #c2c2c2;"><?=$user->first_name?></td>
        <td style="border: solid 1px #c2c2c2;"><?=$user->phone?></td>
        <td style="border: solid 1px #c2c2c2;"><?=$product->name_ru?></td>
        <td style="border: solid 1px #c2c2c2;"><?=$product->product_code?></td>
    </tr>
</table>
<p>Email пользователя: <b><?=$user->user->email?></b></p>
</div>