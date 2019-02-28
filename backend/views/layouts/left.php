<?php
use yii\bootstrap\Nav;
use kartik\nav\NavX;
use yii\widgets\Menu;
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <?= \cebe\gravatar\Gravatar::widget([
                    'email' => \Yii::$app->user->identity->email,
                    'options' => [
                        'class'=>'img-circle'
                    ],
                    'size' => 160
                ]) ?>
            </div>
            <div class="pull-left info">
                <p><?=\Yii::$app->user->identity->profile->name?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> в сети</a>
            </div>
        </div>

        <hr>



        <?=Menu::widget([
            'options' => ['class' => 'sidebar-menu treeview'],
            'items' => [
                ['label' => '<i class="fa fa-database"></i><span>Главная</span>', 'url' => ['/site'], 'visible'=>Yii::$app->user->can('sellerField')],
                ['label' => '<i class="fa fas fa-chart-line"></i><span style="color:#bf0078">Отчеты</span>',
                    'url' => ['#'],
                    'template' => '<a href="{url}" >{label}<i class="fa fa-angle-left pull-right"></i></a>',
                    'items' => [
                        ['label' => '<span>Взятые заказы</span>', 'url' => ['/reports/experts/index']]
                    ],
                    'visible'=>Yii::$app->user->can('headField')
                ],
                ['label' => '<i class="fa far fa-check-square"></i><span style="color:#bf0078">STACK <i style="color:#0dbf00">n/a</i></span>',
                    'url' => ['#'],
                    'template' => '<a href="{url}" >{label}<i class="fa fa-angle-left pull-right"></i></a>',
                    'items' => [
                        ['label' => '<span>Генерация объектов задач</span>', 'url' => ['#']],
                        ['label' => '<span>Установка задач</span>', 'url' => ['#']],
                        [
                            'label' => '<span>Задачи</span>',
                            'url' => ['#'],
                            'template' => '<a href="{url}" >{label}<i class="fa fa-angle-left pull-right"></i></a>',
                            'items' => [
                                ['label' => '<span>Открытые</span>', 'url' => ['/tasks/default/index']],
                                ['label' => '<span>Отправленные на проверку</span>', 'url' => ['#']],
                                ['label' => '<span>Закрытые</span>', 'url' => ['#']],
                                ['label' => '<span>Мои</span>', 'url' => ['#']],
                            ],
                        ],
                    ],
                    'visible'=>Yii::$app->user->can('headField')
                ],
                ['label' => '<i class="fa fa-user"></i>Взаимодействие',
                    'url' => ['#'],
                    'template' => '<a href="{url}" >{label}<i class="fa fa-angle-left pull-right"></i></a>',
                    'items' => [
                        ['label' => '<span>Запросы товаров</span>', 'url' => ['/interaction/requests/index'], 'visible'=>Yii::$app->user->can('headField')],
                        ['label' => '<span>Эксперты</span>', 'url' => ['/experts/index'], 'visible'=>Yii::$app->user->can('headField')],
                        ['label' => '<span>Опросы</span>', 'url' => ['/interaction/quiz/index'], 'visible'=>Yii::$app->user->can('headField')],
                        ['label' => '<span>Уведомления</span>', 'url' => ['/notification/index'], 'visible'=>Yii::$app->user->can('headField')],
                        ['label' => '<span>Данные</span>', 'url' => ['/user-data/index'], 'visible'=>Yii::$app->user->can('headField')],
                    ],
                    'visible'=>Yii::$app->user->can('headField')
                ],
                ['label' => '<i class="fa fa-database"></i>1С',
                    'url' => ['#'],
                    'template' => '<a href="{url}" >{label}<i class="fa fa-angle-left pull-right"></i></a>',
                    'items' => [
                        ['label' => '<span>Выгрузка номенклатуры</span>', 'url' => ['/ut/transfer/index'], 'visible'=>Yii::$app->user->can('access1C')],
                    ],
                    'visible'=>Yii::$app->user->can('access1C')
                ],
                ['label' => '<i class="fa fa-envelope"></i><span>Рассылка</span>', 'url' => ['/mail'], 'visible'=>Yii::$app->user->can('contentField')],
                //['label' => '<i class="fa fa-envelope"></i><span>Ответы на вопросы</span>', 'url' => ['/interaction/expert-questions/bulk-answer'], 'visible'=>Yii::$app->user->can('canAnswer')],
                ['label' => '<i class="fa fas fa-ruble-sign"></i><span>Заказы</span>', 'url' => ['/orders'], 'visible'=>Yii::$app->user->can('contentField')],
                ['label' => '<i class="fa fa-shopping-cart"></i><span>Товары</span>',
                    'url' => ['#'],
                    'template' => '<a href="{url}" >{label}<i class="fa fa-angle-left pull-right"></i></a>',
                    'items' => [
                        ['label' => '<i class="fa fa-gift"></i><span>Каталог</span>', 'url' => ['/categories'], 'visible'=>Yii::$app->user->can('contentField')],
                        ['label' => '<i class="fa fa-bars"></i><span>Типы товаров</span>', 'url' => ['/attributes'], 'visible'=>Yii::$app->user->can('contentField')],
                        ['label' => '<i class="fa fa-bars"></i><span>Бренды</span>', 'url' => ['/content/brands'], 'visible'=>Yii::$app->user->can('contentField')],
                        ['label' => '<i class="fa fa-bars"></i>Списки товаров',
                            'url' => ['#'],
                            'template' => '<a href="{url}" >{label}<i class="fa fa-angle-left pull-right"></i></a>',
                            'items' => [
                                ['label' => 'Спецпредложения', 'url' => ['/lists/specials']],
                                ['label' => 'Слайдер спецпредложений', 'url' => ['/lists/specials-slider']],
                                ['label' => 'Подсвеченные', 'url' => ['/lists/highlight']],
                            ],
                            'visible'=>Yii::$app->user->can('contentField')
                        ],
                    ],
                    'visible'=>Yii::$app->user->can('contentField')
                ],



                ['label' => '<i class="fa fa-folder"></i>Контент',
                    'url' => ['#'],
                    'template' => '<a href="{url}" >{label}<i class="fa fa-angle-left pull-right"></i></a>',
                    'items' => [
                        ['label' => '<i class="fa fa-bars"></i><span>Сетка</span>', 'url' => ['/content/front-grid/index'], 'visible'=>Yii::$app->user->can('headField')||Yii::$app->user->can('/content/front-grid/*')],
                        ['label' => '<i class="fa fa-bars"></i><span>Слайдер</span>', 'url' => ['/content/slider/index'], 'visible'=>Yii::$app->user->can('headField')],
                        ['label' => '<i class="fa fa-bars"></i><span>CSS</span>', 'url' => ['/content/css/index'], 'visible'=>Yii::$app->user->can('headField')],
                        ['label' => '<i class="fa fa-bars"></i><span>Статические страницы</span>', 'url' => ['/pages'], 'visible'=>Yii::$app->user->can('contentField')],
                        ['label' => '<i class="fa fa-bars"></i><span>Боковые бренды</span>', 'url' => ['/sidebarbrands'], 'visible'=>Yii::$app->user->can('contentField')],
                        ['label' => '<i class="fa fa-bars"></i><span>Вторичные страницы</span>', 'url' => ['/secondary'], 'visible'=>Yii::$app->user->can('contentField')],
                        ['label' => '<i class="fa fa-bars"></i><span>Загрузка изображений</span>', 'url' => ['/content/upload/index'], 'visible'=>Yii::$app->user->can('contentField')],
                        ['label' => '<i class="fa fa-bars"></i><span>Соревнования</span>', 'url' => ['/content/article-tour/index'], 'visible'=>Yii::$app->user->can('contentField')],
                        ['label' => '<i class="fa fa-bars"></i><span>Спонсорство</span>', 'url' => ['/content/article-sponsor/index'], 'visible'=>Yii::$app->user->can('contentField')],
                        ['label' => '<i class="fa fa-bars"></i><span>Загрузка изображений</span>', 'url' => ['/content/upload/index'], 'visible'=>Yii::$app->user->can('contentField')],
                    ],
                ],

                ['label' => 'Отзывы',
                    'url' => ['#'],
                    'template' => '<a href="{url}" >{label}<i class="fa fa-angle-left pull-right"></i></a>',
                    'items' => [
                        ['label' => 'Отзывы о магазине', 'url' => ['/ratings']],
                        ['label' => 'Отзывы о товарах', 'url' => ['/ratings/products']],
                    ],
                    'visible'=>Yii::$app->user->can('headField')
                ],
                ['label' => '<i class="fa fas fa-newspaper"></i><span>Новости</span>', 'url' => ['/news'], 'visible'=>Yii::$app->user->can('contentField')],

                ['label' => '<i class="fa fas fa-newspaper"></i><span>Обзоры</span>', 'url' => ['/review'], 'visible'=>Yii::$app->user->can('contentField')],

                ['label' => 'RBAC',
                    'url' => ['#'],
                    'template' => '<a href="{url}" >{label}<i class="fa fa-angle-left pull-right"></i></a>',
                    'items' => [
                        ['label' => 'Администрирование', 'url' => ['/admin/index']],
                        ['label' => 'Маршруты', 'url' => ['/admin/route']],
                        ['label' => 'Разрешения', 'url' => ['/admin/permission']],
                        ['label' => 'Роли', 'url' => ['/admin/role']],
                        ['label' => 'Распределения', 'url' => ['/admin/assignment']],
                    ],
                    'visible'=>Yii::$app->user->can('superField')
                ],
                ['label' => '<i class="fa fas fa-file-code"></i><span>Gii</span>', 'url' => ['/gii'], 'visible'=>Yii::$app->user->can('superField')],
                ['label' => '<i class="fa fas fa-tachometer-alt"></i><span>Debug</span>', 'url' => ['/debug'], 'visible'=>Yii::$app->user->can('superField')],
                ['label' => 'Агрегатные операции',
                    'url' => ['#'],
                    'template' => '<a href="{url}" ><i class="fa fa-cogs"></i>{label}<i class="fa fa-angle-left pull-right"></i></a>',
                    'items' => [
                        ['label' => 'Построение типов товаров', 'url' => ['/plant/types']],
                        ['label' => 'Удаление пустых атрибутов', 'url' => ['/plant/clear-types']],
                        ['label' => 'Атрибуты из тегов', 'url' => ['/plant/tag-types']],
                        ['label' => 'Выгрузка в Yandex маркет', 'url' => ['/plant/yandex']],
                        ['label' => 'Выгрузка в Yandex (Excel)', 'url' => ['/yandexexcel']],
                    ],
                    'visible'=>Yii::$app->user->can('contentField')
                ],
                ['label' => 'Пользователи',
                    'url' => ['#'],
                    'template' => '<a href="{url}" >{label}<i class="fa fa-angle-left pull-right"></i></a>',
                    'items' => [
                        ['label' => 'Список пользователей', 'url' => ['/user/admin/index']],
                        ['label' => 'Зарегистрировать', 'url' => ['/user/admin/create']],
                        ['label' => 'Общий список', 'url' => ['/ouser/index']],
                    ],
                    'visible'=>Yii::$app->user->can('superField')
                ],
                ['label' => 'Пользователи', 'url' => ['/ouser/index'], 'visible'=>!Yii::$app->user->can('contentField')],

                ['label' => 'Настройки',
                    'url' => ['#'],
                    'template' => '<a href="{url}" >{label}<i class="fa fa-angle-left pull-right"></i></a>',
                    'items' => [
                        ['label' => 'Ключ-значение', 'url' => ['/settings'], 'visible'=>Yii::$app->user->can('superField')],
                    ],
                    'visible'=>Yii::$app->user->can('contentField')
                ],
                ['label' => 'Кэш',
                    'url' => ['#'],
                    'template' => '<a href="{url}" >{label}<i class="fa fa-angle-left pull-right"></i></a>',
                    'items' => [
                        ['label' => 'Данные', 'url' => ['/cache/data'], 'visible'=>Yii::$app->user->can('headField')],
                        ['label' => 'Страницы', 'url' => ['/cache/pages'], 'visible'=>Yii::$app->user->can('headField')],
                        ['label' => 'Изображения', 'url' => ['/cache/images'], 'visible'=>Yii::$app->user->can('headField')],
                    ],
                    'visible'=>Yii::$app->user->can('contentField')
                ],


            ],
            'submenuTemplate' => "\n<ul class='treeview-menu'>\n{items}\n</ul>\n",
            'encodeLabels' => false, //allows you to use html in labels
            'activateParents' => true,   ]);  ?>




    </section>

</aside>
