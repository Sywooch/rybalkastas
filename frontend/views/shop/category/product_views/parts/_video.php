<div class="col-md-12">
    <?php
    preg_match_all('/<iframe.*?\/iframe>/i', $model->description_ru, $matches);

    foreach ($matches as $m){
        if(!isset($m[0]))continue;
        echo '<div>'.$m[0].'</div>';
    }
    ?>

</div>