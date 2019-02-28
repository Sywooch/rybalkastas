<?php $this->title = $model->aux_page_name_ru; ?>

<div id="static_page" class="fr-view container">
    <?= $this->render('_index', [
        'model' => $model
    ]); ?>
</div>
