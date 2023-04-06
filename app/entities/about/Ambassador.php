<?php

namespace app\entities\about;

use yii\db\ActiveRecord;

/**
 * @property int id
 * @property string avatar
 * @property string title_ru
 * @property string city_ru
 * @property string text_ru
 * @property string title_en
 * @property string city_en
 * @property string text_en
 * @property string title_de
 * @property string city_de
 * @property string text_de
 * @property string title_vi
 * @property string city_vi
 * @property string text_vi
 * @property string created_at
 * @property string updated_at
 */
class Ambassador extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%ambassadors}}';
    }

    public function getTitle($locale = 'ru-RU')
    {
        $lang = mb_substr($locale, 0, 2);

        $value = 'title_' . $lang;

        return $this->$value;
    }

    public function getCity($locale = 'ru-RU')
    {
        $lang = mb_substr($locale, 0, 2);

        $value = 'city_' . $lang;

        return $this->$value;
    }

    public function getText($locale = 'ru-RU')
    {
        $lang = mb_substr($locale, 0, 2);

        $value = 'text_' . $lang;

        return nl2br($this->$value);
    }
}
