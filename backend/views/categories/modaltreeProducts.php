<?php

/* @var $item \common\models\SCCategories */

use yii\helpers\Html;
use kartik\checkbox\CheckboxX;

?>

<ul class="catlist" style="<?= !isset($static) ? 'display: none' : '' ?>">
    <?php foreach($rootCats as $item):?>
        <?php switch ($type) {
            case 'related':
                $isConnected = $item->relatedExists($main);
                break;
            case 'selfrelated':
                $isConnected = $item->selfRelatedExists($main);
                break;
            case 'same':
                $isConnected = $item->sameExists($main);
                break;
            default:
                $isConnected = false;
        }; ?>

        <li data-type="<?= $type ?>" data-cat="<?= $item->categoryID ?>">
            <?php if($item->hasChilds):?>
                <i class="fa fa-folder"></i>
            <?php endif;?>

            <?php if ($item->hasProducts): ?>
                <div class="row">
                    <?php if ($item->picture): ?>
                        <div class="col-xs-2">
                            <?= Html::img(Yii::$app->urlManagerFrontend->createAbsoluteUrl('/img/products_pictures/' . $item->picture), [
                                'class' => 'file-preview-image img-responsive',
                                'alt'   => $item->name_ru,
                                'title' => $item->name_ru
                            ]) ?>
                        </div>
                    <?php endif; ?>

                    <div class="col-xs-9">
                        <p><?= $item->name_ru ?></p>

                        <?php $countProducts = \common\models\SCProducts::find()->where(['categoryID'=>$item->categoryID])->one(); ?>

                        <?php if (!empty($countProducts)):
                            $countStock  = \common\models\SCProducts::find()->where(['categoryID'=>$item->categoryID])->sum('in_stock');
                            $countStockP = \common\models\SCProducts::find()->where(['categoryID'=>$item->categoryID])->sum('in_stock_provider');
                            if ($countStock > 0) {
                                echo '<p>';
                                if ($countStock > $countStockP) {
                                    echo "<b class='text-success'>В наличии</b>";
                                } else {
                                    echo "<b class='text-danger'>В наличии у поставщиков</b>";
                                }
                                echo '</p>';
                            } ?>
                        <?php endif; ?>

                        <p>
                            <strong>Цена: от <?= json_decode($item->meta_data, true)['minPrice'] ?> руб.</strong>
                        </p>
                    </div>

                    <div class="col-xs-1 pull-right">
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
                    </div>
                </div>
            <?php else: ?>
                <span><?= $item->name_ru ?></span>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>
