<?php
\yii\bootstrap\Modal::begin([
    'header' => '<h2>Выбрать родителя</h2>',
    'toggleButton' => ['label' => 'Перенести', 'class'=>'btn btn-success', 'id'=>'moveModalButton', 'data-id'=>$val],
]);
?>

<div id="moveModal">

</div>

<?php

\yii\bootstrap\Modal::end();


$url = \yii\helpers\Url::to(['load-move-modal']);
$js = <<< JS
$('.parentRadio[checked]').parentsUntil('.primaryParentRoot').show();
 $('.primaryParentRoot a').click(function(e){
     $(this).parent().children('ul').toggle();
 });

$('.parentRadio').change(function(e){
    $('#parentButton').text($(this).parent().children('.name').text());
});

$('#moveModalButton').click(function(e){
    id = $(this).data('id');
    $.post( "$url",{val:id}, function( data ) {
        $( "#moveModal" ).html( data );
    });
});
JS;

$this->registerJs($js);



function makeListItems($a, $val) {
    $out = '';
    foreach($a as $item) {
        $out .= '<li class="list-group-item">';
        $out .= '<a class="name">'.$item['name_ru'].'</a>';
        $out .= '<input value="'.$item['categoryID'].'" name="newParent" type="radio" '.($val==$item['categoryID']?'checked ':'').'class="parentRadio pull-right" />';
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
