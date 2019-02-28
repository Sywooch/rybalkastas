<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Элементы';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-about">
    <h1 class="page-header"><?= Html::encode($this->title) ?></h1>


    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Кнопки</h3>
            </div>
            <div class="box-body pad table-responsive">
                <table class="table table-bordered text-center">
                    <tbody>
                    <tr>
                        <td>Нормальные</td>
                        <td>Большие</td>
                        <td>Маленькие</td>
                        <td>Х-Маленькие</td>
                        <td>Отключенные</td>
                    </tr>
                    <tr>
                        <td>
                            <button type="button" class="btn btn-block btn-default">Дефолт</button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-block btn-default btn-lg">Дефолт</button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-block btn-default btn-sm">Дефолт</button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-block btn-default btn-xs">Дефолт</button>
                        </td>

                        <td>
                            <button type="button" class="btn btn-block btn-default disabled">Дефолт</button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <button type="button" class="btn btn-block btn-primary">Основные</button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-block btn-primary btn-lg">Основные</button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-block btn-primary btn-sm">Основные</button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-block btn-primary btn-xs">Основные</button>
                        </td>

                        <td>
                            <button type="button" class="btn btn-block btn-primary disabled">Основные</button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <button type="button" class="btn btn-block btn-success">Успешно</button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-block btn-success btn-lg">Успешно</button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-block btn-success btn-sm">Успешно</button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-block btn-success btn-xs">Успешно</button>
                        </td>

                        <td>
                            <button type="button" class="btn btn-block btn-success disabled">Успешно</button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <button type="button" class="btn btn-block btn-info">Инфо</button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-block btn-info btn-lg">Инфо</button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-block btn-info btn-sm">Инфо</button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-block btn-info btn-xs">Инфо</button>
                        </td>

                        <td>
                            <button type="button" class="btn btn-block btn-info disabled">Инфо</button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <button type="button" class="btn btn-block btn-warning">Внимание</button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-block btn-warning btn-lg">Внимание</button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-block btn-warning btn-sm">Внимание</button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-block btn-warning btn-xs">Внимание</button>
                        </td>
                        
                        <td>
                            <button type="button" class="btn btn-block btn-warning disabled">Внимание</button>
                        </td>
                    </tr>
                    </tbody></table>
            </div>
            <!-- /.box -->
        </div>
    </div>

    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Разбитые кнопки</h3>
            </div>
            <div class="box-body">
                <!-- Split button -->
                
                <div class="margin">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-flat">Действие</button>
                        <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Действие</a></li>
                            <li><a href="#">Другое действие</a></li>
                            <li><a href="#">Еще одно действие</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Отдельная ссылка</a></li>
                        </ul>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-info btn-flat">Действие</button>
                        <button type="button" class="btn btn-info btn-flat dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Действие</a></li>
                            <li><a href="#">Другое действие</a></li>
                            <li><a href="#">Еще одно действие</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Отдельная ссылка</a></li>
                        </ul>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-danger btn-flat">Действие</button>
                        <button type="button" class="btn btn-danger btn-flat dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Действие</a></li>
                            <li><a href="#">Другое действие</a></li>
                            <li><a href="#">Еще одно действие</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Отдельная ссылка</a></li>
                        </ul>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-success btn-flat">Действие</button>
                        <button type="button" class="btn btn-success btn-flat dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Действие</a></li>
                            <li><a href="#">Другое действие</a></li>
                            <li><a href="#">Еще одно действие</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Отдельная ссылка</a></li>
                        </ul>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-warning btn-flat">Действие</button>
                        <button type="button" class="btn btn-warning btn-flat dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Действие</a></li>
                            <li><a href="#">Другое действие</a></li>
                            <li><a href="#">Еще одно действие</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Отдельная ссылка</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
    </div>

    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Кнопки приложения</h3>
            </div>
            <div class="box-body">
                <a class="btn btn-app">
                    <i class="fa fa-edit"></i> Редактировать
                </a>
                <a class="btn btn-app">
                    <i class="fa fa-play"></i> Играть
                </a>
                <a class="btn btn-app">
                    <i class="fa fa-repeat"></i> Повторить
                </a>
                <a class="btn btn-app">
                    <i class="fa fa-pause"></i> Пауза
                </a>
                <a class="btn btn-app">
                    <i class="fa fa-save"></i> Сохранить
                </a>
                <a class="btn btn-app">
                    <span class="badge bg-yellow">3</span>
                    <i class="fa fa-bullhorn"></i> Уведомления
                </a>
                <a class="btn btn-app">
                    <span class="badge bg-green">300</span>
                    <i class="fa fa-barcode"></i> Товары
                </a>
                <a class="btn btn-app">
                    <span class="badge bg-purple">891</span>
                    <i class="fa fa-users"></i> Пользователи
                </a>
                <a class="btn btn-app">
                    <span class="badge bg-teal">67</span>
                    <i class="fa fa-inbox"></i> Заказы
                </a>
                <a class="btn btn-app">
                    <span class="badge bg-aqua">12</span>
                    <i class="fa fa-envelope"></i> Входящие
                </a>
                <a class="btn btn-app">
                    <span class="badge bg-red">531</span>
                    <i class="fa fa-heart-o"></i> Лайки
                </a>
            </div>
            <!-- /.box-body -->
        </div>
    </div>

    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Социальные кнопки</h3>
            </div>
            <div class="box-body">
                <div class="text-center">
                    <a class="btn btn-social-icon btn-bitbucket"><i class="fa fa-bitbucket"></i></a>
                    <a class="btn btn-social-icon btn-dropbox"><i class="fa fa-dropbox"></i></a>
                    <a class="btn btn-social-icon btn-facebook"><i class="fa fa-facebook"></i></a>
                    <a class="btn btn-social-icon btn-flickr"><i class="fa fa-flickr"></i></a>
                    <a class="btn btn-social-icon btn-foursquare"><i class="fa fa-foursquare"></i></a>
                    <a class="btn btn-social-icon btn-github"><i class="fa fa-github"></i></a>
                    <a class="btn btn-social-icon btn-google"><i class="fa fa-google-plus"></i></a>
                    <a class="btn btn-social-icon btn-instagram"><i class="fa fa-instagram"></i></a>
                    <a class="btn btn-social-icon btn-linkedin"><i class="fa fa-linkedin"></i></a>
                    <a class="btn btn-social-icon btn-tumblr"><i class="fa fa-tumblr"></i></a>
                    <a class="btn btn-social-icon btn-twitter"><i class="fa fa-twitter"></i></a>
                    <a class="btn btn-social-icon btn-vk"><i class="fa fa-vk"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <hr>
    <hr>
    <hr>

    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Инфо-боксы</h3>
            </div>
            <div class="box-body">
                <div class="callout callout-danger">
                    <h4>Опасность!</h4>

                    <p>Текст инфо-бокса, на который будет акцентировано внимание клиента!</p>
                </div>
                <div class="callout callout-info">
                    <h4>Инфо!</h4>

                    <p>Текст инфо-бокса, на который будет акцентировано внимание клиента!</p>
                </div>
                <div class="callout callout-warning">
                    <h4>Внимание!</h4>

                    <p>Текст инфо-бокса, на который будет акцентировано внимание клиента!</p>
                </div>
                <div class="callout callout-success">
                    <h4>Успех!</h4>

                    <p>Текст инфо-бокса, на который будет акцентировано внимание клиента!</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Вкладки</h3>
            </div>
            <div class="box-body">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Вкладка 1</a></li>
                        <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Вкладка 2</a></li>
                        <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">Вкладка 3</a></li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                                Меню <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Действие</a></li>
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Другое действие</a></li>
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Еще одно действие</a></li>
                                <li role="presentation" class="divider"></li>
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Отдельная ссылка</a></li>
                            </ul>
                        </li>
                        <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <b>Lorem Ipsum:</b>

                            Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                            Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                            when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                            It has survived not only five centuries, but also the leap into electronic typesetting,
                            remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset
                            sheets containing Lorem Ipsum passages, and more recently with desktop publishing software
                            like Aldus PageMaker including versions of Lorem Ipsum.
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="tab_2">
                             2 Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                            Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                            when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                            It has survived not only five centuries, but also the leap into electronic typesetting,
                            remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset
                            sheets containing Lorem Ipsum passages, and more recently with desktop publishing software
                            like Aldus PageMaker including versions of Lorem Ipsum.
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="tab_3">
                            3 Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                            Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                            when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                            It has survived not only five centuries, but also the leap into electronic typesetting,
                            remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset
                            sheets containing Lorem Ipsum passages, and more recently with desktop publishing software
                            like Aldus PageMaker including versions of Lorem Ipsum.
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
            </div>
        </div>
    </div>

    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Слайдеры</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row margin">
                    <div class="col-sm-6">
                        <input type="text" value="" class="slider form-control" data-slider-min="-200" data-slider-max="200" data-slider-step="5" data-slider-value="[-100,100]" data-slider-orientation="horizontal" data-slider-selection="before" data-slider-tooltip="show" data-slider-id="red">

                        <input type="text" value="" class="slider form-control" data-slider-min="-200" data-slider-max="200" data-slider-step="5" data-slider-value="[-100,100]" data-slider-orientation="horizontal" data-slider-selection="before" data-slider-tooltip="show" data-slider-id="blue">

                        <input type="text" value="" class="slider form-control" data-slider-min="-200" data-slider-max="200" data-slider-step="5" data-slider-value="[-100,100]" data-slider-orientation="horizontal" data-slider-selection="before" data-slider-tooltip="show" data-slider-id="green">

                        <input type="text" value="" class="slider form-control" data-slider-min="-200" data-slider-max="200" data-slider-step="5" data-slider-value="[-100,100]" data-slider-orientation="horizontal" data-slider-selection="before" data-slider-tooltip="show" data-slider-id="yellow">

                        <input type="text" value="" class="slider form-control" data-slider-min="-200" data-slider-max="200" data-slider-step="5" data-slider-value="[-100,100]" data-slider-orientation="horizontal" data-slider-selection="before" data-slider-tooltip="show" data-slider-id="aqua">

                        <input type="text" value="" class="slider form-control" data-slider-min="-200" data-slider-max="200" data-slider-step="5" data-slider-value="[-100,100]" data-slider-orientation="horizontal" data-slider-selection="before" data-slider-tooltip="show" data-slider-id="purple">

                    </div>
                    <div class="col-sm-6 text-center">
                        <input type="text" value="" class="slider form-control" data-slider-min="-200" data-slider-max="200" data-slider-step="5" data-slider-value="[-100,100]" data-slider-orientation="vertical" data-slider-selection="before" data-slider-tooltip="show" data-slider-id="red">
                        <input type="text" value="" class="slider form-control" data-slider-min="-200" data-slider-max="200" data-slider-step="5" data-slider-value="[-100,100]" data-slider-orientation="vertical" data-slider-selection="before" data-slider-tooltip="show" data-slider-id="blue">
                        <input type="text" value="" class="slider form-control" data-slider-min="-200" data-slider-max="200" data-slider-step="5" data-slider-value="[-100,100]" data-slider-orientation="vertical" data-slider-selection="before" data-slider-tooltip="show" data-slider-id="green">
                        <input type="text" value="" class="slider form-control" data-slider-min="-200" data-slider-max="200" data-slider-step="5" data-slider-value="[-100,100]" data-slider-orientation="vertical" data-slider-selection="before" data-slider-tooltip="show" data-slider-id="yellow">
                        <input type="text" value="" class="slider form-control" data-slider-min="-200" data-slider-max="200" data-slider-step="5" data-slider-value="[-100,100]" data-slider-orientation="vertical" data-slider-selection="before" data-slider-tooltip="show" data-slider-id="aqua">
                        <input type="text" value="" class="slider form-control" data-slider-min="-200" data-slider-max="200" data-slider-step="5" data-slider-value="[-100,100]" data-slider-orientation="vertical" data-slider-selection="before" data-slider-tooltip="show" data-slider-id="purple">
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>

    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Модальные окна</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?php
                \yii\bootstrap\Modal::begin([
                    'header' => '<h2>Обычное окно</h2>',
                    'footer' => '<button class="btn btn-default pull-left" data-dismiss="modal">Закрыть</button><button type="button" class="btn btn-primary" data-dismiss="modal">Сохранить</button>',
                    'toggleButton' => ['label' => 'Обычное окно', 'class'=>'btn btn-primary'],
                ]);

                echo "<div id='modalContent'>Привет!</div>";

                \yii\bootstrap\Modal::end();
                ?>


                <?php
                \yii\bootstrap\Modal::begin([
                    'header' => '<h2>Инфо окно</h2>',
                    'footer' => '<button class="btn btn-outline pull-left" data-dismiss="modal">Закрыть</button><button type="button" class="btn btn-outline" data-dismiss="modal">Сохранить</button>',
                    'toggleButton' => ['label' => 'Инфо окно', 'class'=>'btn btn-info'],
                    'options' => ['class'=>'modal-info fade']
                ]);

                echo "<div id='modalContent'>Привет!</div>";

                \yii\bootstrap\Modal::end();
                ?>
            </div>
        </div>

    </div>
</div>


<?php
$js = <<< JS

$('.slider').slider();

JS;

$this->registerJs($js);

?>