<?php

use yii\widgets\Breadcrumbs;
use dmstr\widgets\Alert;

?>

<div class="content-wrapper">
    <section class="content-header">
        <?php if (isset($this->blocks['content-header'])) { ?>
            <h1><?= $this->blocks['content-header'] ?></h1>
        <?php } else { ?>
            <h1>
                <?php
                if ($this->title !== null) {
                    echo \yii\helpers\Html::encode($this->title);
                } else {
                    echo \yii\helpers\Inflector::camel2words(
                        \yii\helpers\Inflector::id2camel($this->context->module->id)
                    );
                    echo ($this->context->module->id !== \Yii::$app->id) ? '<small>Module</small>' : '';
                } ?>
            </h1>
        <?php } ?>

        <?php try {
            echo Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]);
        } catch (Exception $e) {
            $e->getMessage();
        } ?>
    </section>

    <section class="content">
        <?php try {
            echo Alert::widget();
        } catch (Exception $e) {
            $e->getMessage();
        } ?>

        <?= $content ?>

        <div style="clear: both;"></div>
        <div style="clear: both;"></div>
    </section>
</div>
