<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">Номенклатура</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-default selectAll"><i class="fa fa-check"></i> Отметить все
            </button>
        </div>
        <!-- /.box-tools -->
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="folder">
            <ol>
                <?php foreach ($nomenclature as $n): ?>
                    <li data-code="<?= $n->code ?>">
                        <?php if ($n->isFolder): ?>
                            <a href="<?= \yii\helpers\Url::to(['index', 'code' => $n->code]) ?>">
                                <i class="fa fa-folder"></i> <?= $n->name ?>
                            </a>
                        <?php else: ?>
                            <?php if ($n->isLoaded): ?>
                                <div style="color:green">
                                    <i class="fa fa-check"></i> <?= $n->name ?>
                                </div>
                            <?php else: ?>
                                <div>
                                    <input type="checkbox" class="checkNomenclature"
                                           data-code="<?= $n->code ?>"/> <?= $n->name ?>
                                </div>
                            <?php endif; ?>

                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ol>
        </div>
    </div>
    <!-- /.box-body -->
</div>