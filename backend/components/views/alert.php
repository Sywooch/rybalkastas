<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 23.10.2015
 * Time: 12:13
 */
?>

<div class="modal modal-danger fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?=$alert->title;?></h4>
            </div>
            <div class="modal-body">
                <?=$alert->txt;?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>

<?php
$str = <<< JS
    $(window).load(function(){
        $('#alertModal').modal('show');
    });
JS;
$this->registerJS($str);
?>