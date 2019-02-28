<?php
$tree = \common\models\SCCategories::returnRecursiveTree();
?>

<div class="primaryParentRoot">
    <?=makeList($tree, $val)?>
</div>
<button type="button" class="btn btn-success btn-block" id="acceptMove">Перенести выбранные</button>

<?php
$url = \yii\helpers\Url::to(['move-products']);
$js = <<< JS
$('.parentRadio[checked]').parentsUntil('.primaryParentRoot').show();
 $('.primaryParentRoot a').click(function(e){
     $(this).parent().children('ul').toggle();
 });

$('.parentRadio').change(function(e){
    $('#parentButton').text($(this).parent().children('.name').text());
});

$('#acceptMove').click(function(){
    obj = $(this);
    $.ajax({
      type: "POST",
      url: "$url",
      data: obj.closest('form').serialize(),
      success: function(data){
          if(data.samecat === 'false'){
              obj.closest('form').find('input:checked').parent().remove();
              $('.modal').modal('hide');

          }
      },
      dataType: 'json'
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