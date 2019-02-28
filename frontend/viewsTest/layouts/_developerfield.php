<div id="devField">
    <div class="container">
        <div class="form-group">
            <input type="email" class="form-control" id="devBg" aria-describedby="emailHelp" placeholder="Фон сайта">
        </div>
    </div>

</div>

<style>
    #devField {
        position: fixed;
        padding: 10px;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.46);
        z-index: 200;
    }
</style>

<?php $js = <<< JS

$('#devBg').keyup(function(e){
    $('body').css({'background-image': 'url('+$(this).val()+')'})
});
JS;
$this->registerJs($js);
?>