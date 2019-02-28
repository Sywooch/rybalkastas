<?php

/* @var $item \common\models\SCCategories */

use kartik\checkbox\CheckboxX;

?>

<ul class="catlist" style="<?= !isset($static) ? 'display: none' : '' ?>">
    <?php foreach($rootCats as $item):?>
        <?php $isConnected = false;

        if ($type == 'parents') {
            $isConnected = $item->parentExists($main);
        } elseif ($type == 'childs') {
            $isConnected = $item->childExists($main);
        } ?>

        <?php if (!$item->hasProducts): ?>
            <li data-type="<?= $type ?>" data-cat="<?= $item->categoryID ?>">
                <?php if ($item->hasChilds): ?>
                    <i class="fa fa-folder"></i>
                <?php endif; ?>

                <span><?= $item->name_ru ?></span>

                <?php try {
                    echo CheckboxX::widget([
                        'name' => $type . '[' . $item->categoryID . ']',
                        'options' => ['id' => $type . '_' . $item->categoryID],
                        'value' => $isConnected,
                        'pluginOptions' => [
                            'size' => 'xs',
                            'threeState' => false,
                        ]
                    ]);
                } catch (Exception $e) {
                    $e->getMessage();
                } ?>
            </li>
        <?php endif;?>
    <?php endforeach; ?>
</ul>
