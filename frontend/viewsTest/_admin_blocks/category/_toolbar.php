<nav class="navbar navbar-default">
    <div class="container-fluid">


        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <p class="navbar-btn">
                        <a href="<?=\yii\helpers\Url::to(['shop-admin/toggle-info', 'id'=>$model->categoryID])?>" data-toggle="tooltip" title="Включить/отключить всплывающую информацию" class="btn btn-info btn-flat"><i class="fa fa-info" aria-hidden="true"></i></a>
                        <a href="<?=\yii\helpers\Url::to(['shop-admin/clear-cache-category', 'id'=>$model->categoryID])?>" data-toggle="tooltip" title="Сбросить кэш" class="btn btn-info btn-flat"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                        <a target="_blank" href="<?=\Yii::$app->urlManagerBackend->createAbsoluteUrl(['categories/update', 'id'=>$model->categoryID])?>" data-toggle="tooltip" title="Редактировать в админке" class="btn btn-info btn-flat"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                    </p>
                </li>
            </ul>
        </div>
    </div>
</nav>



