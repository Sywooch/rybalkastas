<script src="http://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>

<?php
$file = 'http://gw.edostavka.ru:11443/pvzlist.php';
$scriptElement1 = '';
$scriptElement2 = '';
$downsArray = array();
$name = !empty($_GET['nameid'])?$_GET['nameid']:'';
$i = 0;

if(!$xml = simplexml_load_file($file))
    exit('Failed to open '.$file);
foreach($xml as $address){
    $scriptElement1 .= "myGeoObject".$i." = new ymaps.GeoObject({
                // Описание геометрии.
                geometry: {
                    type: 'Point',
                    coordinates: [".$address['coordY'][0].", ".$address['coordX'][0]."]
                },
                // Свойства.
                properties: {
                    // Контент метки.
                    balloonContent: '".addslashes($address['Address'][0])." <br> ".$address['WorkTime'][0]." <br> тел. ".$address['Phone'][0]."'
                }
            }, {
                // Опции.
                // Иконка метки будет растягиваться под размер ее содержимого.
                preset: 'islands#circleIcon',
                iconColor: '#3caa3c',
                // Метку можно перемещать.
                draggable: false,

            });";

    $scriptElement2 .= "myMap.geoObjects.add(myGeoObject".$i.");";
    $downsArray[] = array('id'=>(int)$address['CityCode'][0], 'city'=>(string)$address['City'][0], 'X'=> (string)$address['coordX'][0], 'Y'=>(string)$address['coordY'][0]);
    $i++;
}
$dropdownlist = '';
$n = 0;
$result = array();
foreach ($downsArray as $data) {
    $id = $data['id'];
    if (isset($result[$id])) {
        $result[$id][] = $data;
    } else {
        $result[$id] = array($data);
    }
}

foreach($result as $city){
    $dropdownlist .= 'new ymaps.control.ListBoxItem({
                    data: {
                        content: "'.$city[0]['city'].'",
                        center: ['.$city[0]['Y'].', '.$city[0]['X'].'],
                        zoom: 9
                    }
                }),';
    $n++;
}
?>

<script type="text/javascript">
    ymaps.ready(init);

    function init () {
        var myMap = new ymaps.Map("<?php if(empty($name)):echo 'map'; else:echo $name; endif;?>", {
                center: [55.76, 37.64],
                zoom: 10,
                controls: []
            }),

            ListBoxLayout = ymaps.templateLayoutFactory.createClass(

                // Этот элемент будет служить контейнером для элементов списка.
                // В зависимости от того, свернут или развернут список, этот контейнер будет
                // скрываться или показываться вместе с дочерними элементами.
                "<ul id='my-listbox'" +
                " class='dropdown-menu' role='menu' aria-labelledby='dropdownMenu'" +
                " style='display: {% if state.expanded %}block{% else %}none{% endif %};'></ul>", {

                    build: function() {
                        // Вызываем метод build родительского класса перед выполнением
                        // дополнительных действий.
                        ListBoxLayout.superclass.build.call(this);

                        this.childContainerElement = $('#my-listbox').get(0);
                        // Генерируем специальное событие, оповещающее элемент управления
                        // о смене контейнера дочерних элементов.
                        this.events.fire('childcontainerchange', {
                            newChildContainerElement: this.childContainerElement,
                            oldChildContainerElement: null
                        });
                    },

                    // Переопределяем интерфейсный метод, возвращающий ссылку на
                    // контейнер дочерних элементов.
                    getChildContainerElement: function () {
                        return this.childContainerElement;
                    },

                    clear: function () {
                        // Заставим элемент управления перед очисткой макета
                        // откреплять дочерние элементы от родительского.
                        // Это защитит нас от неожиданных ошибок,
                        // связанных с уничтожением dom-элементов в ранних версиях ie.
                        this.events.fire('childcontainerchange', {
                            newChildContainerElement: null,
                            oldChildContainerElement: this.childContainerElement
                        });
                        this.childContainerElement = null;
                        // Вызываем метод clear родительского класса после выполнения
                        // дополнительных действий.
                        ListBoxLayout.superclass.clear.call(this);
                    }
                }),
            ListBoxItemLayout = ymaps.templateLayoutFactory.createClass(
                "<li><a>{{data.content}}</a></li>"
            ),

            // Создадим 2 пункта выпадающего списка
            listBoxItems = [
                <?=$dropdownlist;?>
            ],

            // Теперь создадим список, содержащий 2 пунтка.
            listBox = new ymaps.control.ListBox({
                items: listBoxItems,
                data: {
                    title: 'Выберите город'
                },
                options: {
                    // С помощью опций можно задать как макет непосредственно для списка,
                    layout: ListBoxLayout,
                    // так и макет для дочерних элементов списка. Для задания опций дочерних
                    // элементов через родительский элемент необходимо добавлять префикс
                    // 'item' к названиям опций.
                    itemLayout: ListBoxItemLayout
                }
            });

        listBox.events.add('click', function (e) {
            // Получаем ссылку на объект, по которому кликнули.
            // События элементов списка пропагируются
            // и их можно слушать на родительском элементе.
            var item = e.get('target');
            // Клик на заголовке выпадающего списка обрабатывать не надо.
            if (item != listBox) {
                myMap.setCenter(
                    item.data.get('center'),
                    item.data.get('zoom')
                );
            }
        });

        myMap.controls.add(listBox, {float: 'left'});

        // Создаем геообъект с типом геометрии "Точка".
        <?=$scriptElement1;?>
        <?=$scriptElement2;?>

        //myMap.geoObjects.add(myGeoObject);
    }

</script>
<div style="width: 100%;height:100%" id="<?php if(empty($name)):echo 'map'; else:echo $name; endif;?>"></div>

