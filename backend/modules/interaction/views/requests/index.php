<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 31.12.2015
 * Time: 13:12
 */
use yii\helpers\Url;

?>


<div class="col-md-12">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Запросы отсутствующих товаров</h3>
        </div>
        <div class="box-body">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Актуальные</a></li>
                <li role="presentation"><a href="#sent" aria-controls="profile" role="tab" data-toggle="tab">Отправленные</a></li>
            </ul>

            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="home">
                    <table class="table table-bordered table-striped table-hover dataTable">
                        <tr role="row">
                            <th>Продукт</th>
                            <th>Количество запросов</th>
                        </tr>
                        <?php $i=1; foreach($reqs as $r):?>
                            <?php if(empty($r->product)){
                               $r->delete();
                                continue;
                            }?>
                            <tr class="<?php if($i%2==0):?>odd<?php else:?>oven<?php endif;?>">
                                <td>
                                    <a href="http://rybalkashop.ru/"><?=$r->product->name_ru;?></a>
                                </td>
                                <td>
                                    <?=$r->count;?>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    </table>
                </div>
                <div role="tabpanel" class="tab-pane" id="sent">
                    <table class="table table-bordered table-striped table-hover dataTable">
                        <tr role="row">
                            <th>Продукт</th>
                            <th>Количество запросов</th>
                        </tr>
                        <?php $i=1; foreach($reqsSent as $r):?>
                            <?php if(empty($r->product)){
                                $r->delete();
                                continue;
                            }?>

                            <tr class="<?php if($i%2==0):?>odd<?php else:?>oven<?php endif;?>">
                                <td>
                                    <a href="http://rybalkashop.ru/"><?=$r->product->name_ru;?></a>
                                </td>
                                <td>
                                    <?=$r->count;?>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    </table>
                </div>
            </div>


        </div>
    </div>

</div>



