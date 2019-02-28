<?php

$obj = \common\models\SCCategories::findOne($val);
if(empty($obj)){
    $button = 'root';
} else {
    $button = $obj->name_ru;
}

\yii\bootstrap\Modal::begin([
    'header' => '<h2>Выбрать родителя</h2>',
    'toggleButton' => ['label' => $button, 'class'=>'btn btn-success', 'id'=>'parentButton'],
]);
$tree = \common\models\SCCategories::returnRecursiveTree();
?>

<div class="primaryParentRoot">
<?=makeList($tree, $val)?>
</div>



<?php

\yii\bootstrap\Modal::end();



$js = <<< JS
$('.parentRadio[checked]').parentsUntil('.primaryParentRoot').show();
 $('.primaryParentRoot a').click(function(e){
     $(this).parent().children('ul').toggle();
 });

$('.parentRadio').change(function(e){
    $('#parentButton').text($(this).parent().children('.name').text());
});
JS;

$this->registerJs($js);



function makeListItems($a, $val) {
    $out = '';
    foreach($a as $item) {
        $out .= '<li class="list-group-item">';
        $out .= '<a class="name">'.$item['name_ru'].'</a>';
        $out .= '<input value="'.$item['categoryID'].'" name="SCCategories[parent]" type="radio" '.($val==$item['categoryID']?'checked ':'').'class="parentRadio pull-right" />';
        if(array_key_exists('nodes', $item)) {
            $out .= makeList($item['nodes'], $val);
        }
        $out .= '</li>';
    }

    return $out;
}

function makeList($a, $val) {

    $items = makeListItems($a, $val);
    if(!empty($items)){
        $out = '<ul class="list-group">';
        $out .= $items;
        $out .= '</ul>';
    } else {
        $out = '';
    }


    return $out;
}

?>

<style>
    .primaryParentRoot > ul ul{
        display: none;
        margin-top: 10px;
    }

    .primaryParentRoot a.name{
        border-bottom: dashed 1px;
    }
</style>
