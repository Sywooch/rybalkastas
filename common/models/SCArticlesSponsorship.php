<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "SC_articles_sponsorship".
 *
 * @property int $NID
 * @property string $add_date
 * @property string $title_en
 * @property string $title_ru
 * @property string $picture
 * @property string $textToPublication_en
 * @property string $textToPublication_ru
 * @property string $textToMail
 * @property int $add_stamp
 * @property int $priority
 * @property int $emailed
 * @property int $brand
 * @property string $textMini
 * @property string $textPreview
 * @property int $published
 * @property string $tpl
 * @property string $created_at
 * @property string $updated_at
 * @property string $published_at
 */
class SCArticlesSponsorship extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'SC_articles_sponsorship';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title_en', 'title_ru', 'textToPublication_en', 'textToPublication_ru', 'textToMail', 'textMini', 'textPreview'], 'string'],
            [['add_stamp', 'priority', 'emailed', 'brand', 'published'], 'integer'],
            [['add_date'], 'string', 'max' => 30],
            [['picture'], 'string', 'max' => 3000],
            [['tpl', 'created_at', 'updated_at', 'published_at'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'NID' => 'Nid',
            'add_date' => 'Дата добавления',
            'title_en' => 'Title En',
            'title_ru' => 'Заголовок',
            'picture' => 'Картинка',
            'textToPublication_en' => 'Text To Publication En',
            'textToPublication_ru' => 'Текст новости',
            'textToMail' => 'Text To Mail',
            'add_stamp' => 'Add Stamp',
            'priority' => 'Priority',
            'emailed' => 'Emailed',
            'brand' => 'Привязка к бренду',
            'textMini' => 'Краткий текст',
            'textPreview' => 'Text Preview',
            'published' => 'Статус',
            'sort_order' => 'Порядок',
        ];
    }


    public function getDate(){
        if (date('Y-m-d') == date('Y-m-d', strtotime($this->add_date))) {
            return 'Сегодня в '.date('H:i', strtotime($this->add_date));
        } elseif(date('Ymd', strtotime($this->add_date)) == date('Ymd', strtotime('yesterday'))){
            return 'Вчера в '.date('H:i', strtotime($this->add_date));
        } else {
            if(date('Y') > date('Y', strtotime($this->add_date))){
                return $this->replaceMonth(date('d F Y в H:i', strtotime($this->add_date)));
            } else {
                return $this->replaceMonth(date('d F в H:i', strtotime($this->add_date)));
            }
        }
    }

    function replaceMonth($date){
        $date = str_replace('January', 'Января', $date);
        $date = str_replace('February', 'Февраля', $date);
        $date = str_replace('March', 'Марта', $date);
        $date = str_replace('April', 'Апреля', $date);
        $date = str_replace('May', 'Мая', $date);
        $date = str_replace('June', 'Июня', $date);
        $date = str_replace('July', 'Июля', $date);
        $date = str_replace('August', 'Августа', $date);
        $date = str_replace('September', 'Сентября', $date);
        $date = str_replace('October', 'Октября', $date);
        $date = str_replace('November', 'Ноября', $date);
        $date = str_replace('December', 'Декабря', $date);

        return $date;
    }

    public function getImage()
    {
        $fileExtension =  pathinfo($this->picture, PATHINFO_EXTENSION);
        $fileName =  pathinfo($this->picture, PATHINFO_FILENAME);
        return $fileName.'.'.$fileExtension;
    }
}
