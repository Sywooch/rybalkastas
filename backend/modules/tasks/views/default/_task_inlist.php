<?php

$path = 'ROOT > ';
foreach ($model->entity->path as $item) {
    if ($item['id'] == $model->entity->categoryID) continue;
    $path .= $item['name'].' > ';
}
$fields = \yii\helpers\Json::decode($fields = $model->json_fields);
$assign = \common\models\User::findOne($model->assigned_to);
$assign_profile = $assign->profile;
?>

<div class="panel-group">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" href="#collapse<?=$model->id?>"><?=$path.$model->entity->object_name?></a>
            </h4>
        </div>
        <div id="collapse<?=$model->id?>" class="panel-collapse collapse">
            <div class="panel-body"><?=count($fields)?> полей для заполнения</div>
            <div class="panel-footer">Ответственный: <?=$assign_profile->name?></div>
        </div>
    </div>
</div>