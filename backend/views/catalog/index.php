<?php
 \yii\jui\JuiAsset::register($this);?>



<div class="row">
    <div class="col-md-12" id="catalog">
        <h1>Управление каталогом</h1>

        <div id="left"><?=$this->render('_sideblock', ['model'=>$left,'id'=>$id1, 'products'=>$left_p, 'window'=>'left']);?></div>
        <div id="right"><?=$this->render('_sideblock', ['model'=>$right,'id'=>$id2, 'products'=>$right_p, 'window'=>'right']);?></div>
    </div>

</div>

<script>
    function reload(data) {
        $('.modal-backdrop').remove();
        $('#left').html(data.left);
        $('#right').html(data.right);

        $('#left ul.products').sortable({connectWith: '#right ul.products'});
        $('#left ul.categories').sortable({connectWith: '#right ul.categories'});
        $('#right ul.products').sortable({connectWith: '#left ul.products'});
        $('#right ul.categories').sortable({connectWith: '#left ul.categories'});
    }
</script>

<?php
$url = \yii\helpers\Url::to(['re-render']);
$urlMove = \yii\helpers\Url::to(['move']);
$urlMoveP = \yii\helpers\Url::to(['move-product']);
$urlNewFolder = \yii\helpers\Url::to(['new-folder']);
$js = <<< JS
    $('#left ul.products').sortable({connectWith: '#right ul.products'});
    $('#left ul.categories').sortable({connectWith: '#right ul.categories'});
    $('#right ul.products').sortable({connectWith: '#left ul.products'});
    $('#right ul.categories').sortable({connectWith: '#left ul.categories'});
    $('#catalog').on('click', '.opencat', function(e) {
      e.preventDefault();
      
      id = 0;
      id2 = 0;
      
      if($(this).closest('.column').data('window') === 'left'){
          id = $(this).data('id');
          id2 = $('.column[data-window="right"]').data('id');
      } else {
          id = $('.column[data-window="left"]').data('id');
          id2 = $(this).data('id');
      }
      
      $.ajax({
          type: "GET",
          url: "$url",
          data: {id: id, id2: id2},
          success: function(data){
              reload(data);
          },
          dataType: 'json'
        });
    })    
    
    $('#catalog').on("sortreceive", 'ul.categories', function(event, ui)
    {
        item = ui.item;
        id = item.find('a').data('id');
        newParent = $(this).closest('.column').data('id');
        
        $.ajax({
          type: "POST",
          url: "$urlMove",
          data: {id: id, category: newParent, left: $('.column[data-window="left"]').data('id'), right: $('.column[data-window="right"]').data('id')},
          success: function(data){
              reload(data);
          },
          dataType: 'json'
        });
        
    });
    
    $('#catalog').on("sortreceive", 'ul.products', function(event, ui)
    {
        item = ui.item;
        id = item.find('a').data('product');
        newParent = $(this).closest('.column').data('id');
        
        $.ajax({
          type: "POST",
          url: "$urlMoveP",
          data: {id: id, category: newParent, left: $('.column[data-window="left"]').data('id'), right: $('.column[data-window="right"]').data('id')},
          success: function(data){
              reload(data);
          },
          dataType: 'json'
        });
        
    });
    
    $('#catalog').on('click', '.createNewFolder', function(e) {
      name = $(this).closest('.modal-body').find('input').val();
      parent = $(this).closest('.column').data('id');
      $.ajax({
          type: "POST",
          url: "$urlNewFolder",
          data: {name: name, category: parent, left: $('.column[data-window="left"]').data('id'), right: $('.column[data-window="right"]').data('id')},
          success: function(data){
              reload(data);
          },
          dataType: 'json'
        });
    })
    
JS;

$this->registerJs($js);
?>