<?php

namespace backend\forms;

use yii\base\Model;

/**
 * Class ShopLogisticsForm
 * @package backend\forms
 *
 * @author Dmitriy Mosolov
 * @version 1.0
 *
 */
class ShopLogisticsForm extends Model
{
    public $api_id; // API KEY который есть в кабинете
    public $code; // Уникальный код доставки, который возвращается после добавления доставки, его нужно указывать если доставку нужно обновить
    public $delivery_date; // Дата доставки заказа. формат: YYYY-MM-DD
    public $picking_date; // Дата комплектации заказа. формат: YYYY-MM-DD указывать в случае если товары хранятся у Shop-logistics
    public $date_transfer_to_store; // Дата поступления заказа на склад Shop-logistics. формат: YYYY-MM-DD
    public $from_city; // Доставка из города. Значение: название города или код города из словаря Shop-logistics
    public $to_city; // Доставка в город. Значение: название города или код города из словаря Shop-logistics
    public $time_from; // Время доставки ОТ. формат: HH:MM
    public $time_to; // Время доставки ДО. формат: HH:MM
    public $order_id; // Номер заказа в магазине клиента. Данный номер должен быть уникальным для определенной даты доставки
    public $metro; // Метро. Значение: название метро или код из словаря Shop-logistics
    public $address; // Адрес доставки
    public $address_index; // Адрес индекс
    public $contact_person; // Контактное лицо
    public $phone; // Телефон покупателя
    public $phone_sms; // Телефон для смс
    public $price; // Стоимость, считается автоматически (стоимость товара + стоимость доставки - скидка)
    public $ocen_price; // Оценочная стоимость
    public $additional_info; // Дополнительная информация
    public $site_name; // Название сайта (печатается на наклейках, подставляет в смс)
    public $pickup_place; // Пункт самовывоза. значение: параметр code_id из функции get_dictionary с параметром pickup.
    public $zabor_places_code; // Код склада
    public $partial_ransom; // Частичный выкуп. Значение 0 или 1, если передать пустую строку, берется значение из поля "Частичный выкуп" в разделе ЛК "Настройки".
    public $payment_cards; // Оплата картами разрешена. Значение 0 или 1
    public $prohibition_opening_to_pay; // Запретить вскрытия заказа до оплаты. Значение 0 или 1.
    public $delivery_price_for_customer; // Цена доставки для покупателя. указывать только для частичного выкупа
    public $delivery_price_for_customer_required; // Брать цену доставку при полном отказе (0 или 1)
    public $delivery_price_porog_for_customer; // Бесплатная доставка свыше.
    public $delivery_discount_for_customer; // Скидка для покупателя.
    public $delivery_discount_porog_for_customer; // Минимальный порог для скидки.
    public $return_shipping_documents; // Возврат сопроводительных документов. Значение 0 или 1, если передать пустую строку, берется значение из поля "Возврат сопроводительных документов" в разделе ЛК "Настройки"
    public $use_from_canceled; // Заказ взять из Отмен на складе Shop-Logistics. Значение 0 или 1
    public $add_product_from_disct; // Брать товар со склада хранения. Если значение этого поля 1, то каждый артикул переданных в доставке товаров, будет идентифицироваться с артикулами товаров из раздела ЛК "Ваши товары".
    public $number_of_place; // Количество мест в доставке
    public $delivery_speed; // Скорость доставки. значения: normal или express
    public $shop_logistics_cheque; // Чек Shop-logistics . значения: 1 или 0, если передать пустую строку, берется значение из поля "С чеком Shop-Logistics" в разделе ЛК "Настройки"
    public $return_from_reciver; // Возврат от получателя (0 или 1)
    public $delivery_partner; // Код партнера для выполнения курьерской доставки, если партнер не задан или он не доставляет в указанный город, будет выбран партнер по умолчанию
    public $customer_email; // Email получателя
}
