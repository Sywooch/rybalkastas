<div class="col-md-12 box-rs images">
    <?php
    preg_match_all('/<img.*?>/i', $model->description_ru, $matches);


    foreach ($matches[0] as $m){
        //if(!isset($m[0]))continue;
        $img = preg_replace('/style=".*?"/i', "class=\"img-responsive\"", $m);


        echo '<div class="text-center">'.$img.'</div>';
    }
    ?>
    <div class="clearfix"></div>
</div>
<div class="clearfix"></div>