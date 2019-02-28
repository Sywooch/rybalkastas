var ourWidjet = new ISDEKWidjet ({
    defaultCity: 'Москва', //какой город отображается по умолчанию
    cityFrom:    'Москва', // из какого города будет идти доставка
    country:     'Россия', // можно выбрать страну, для которой отображать список ПВЗ
    link:        'forpvz', // id элемента страницы, в который будет вписан виджет
    path:        '/js/cdek/scripts/', //директория с бибилиотеками
    servicepath: '/cdek/service.php' //ссылка на файл service.php на вашем сайте
});
