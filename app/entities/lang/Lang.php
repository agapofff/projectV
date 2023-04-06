<?php

namespace app\entities\lang;

use app\entities\admin\Country;
use app\entities\admin\Store;
use Yii;
use yii\db\ActiveRecord;

/**
 * @property int id
 * @property string url
 * @property string iso
 * @property string name
 * @property int store_id
 * @property string currency_iso
 * @property int active
 * @property string created_at
 * @property string updated_at
 */
class Lang extends ActiveRecord
{
    static $current = null;

    public static function tableName(): string
    {
        return '{{%langs}}';
    }

    ####################################################################################################

    public function getLangTranslators()
    {
        return $this->hasMany(LangTranslator::class, ['lang_id' => 'id'])->alias('lt')
            ->orderBy('id ASC');
    }

    public function getFullName()
    {
        return $this->iso . ' — ' . $this->name;
    }

    ####################################################################################################

    public static function create(
        $id,
        $url,
        $name
    )
    {
        $model = new self();
        $model->id = $id;
        $model->url = $url;
        $model->name = $name;

        return $model;
    }

    public function edit(
        $id,
        $url,
        $iso,
        $name,
        $store_id,
        $currency_iso,
        $active
    )
    {
        $this->id = $id;
        $this->url = $url;
        $this->iso = $iso;
        $this->name = $name;
        $this->store_id = $store_id;
        $this->currency_iso = $currency_iso;
        $this->active = $active;
    }

    ####################################################################################################

    public function getCountries()
    {
        return $this->hasMany(Country::class, ['lang_id' => 'id']);
    }

    public function getStore()
    {
        return $this->hasOne(Store::class, ['id' => 'store_id'])->alias('s');
    }

    ####################################################################################################

    /**
     * Получение текущего объекта языка
     */
    public static function getCurrent()
    {
        if (self::$current === null) {
            self::$current = self::getDefault();
        }
        return self::$current;
    }

    /**
     * Установка текущего объекта языка и локаль пользователя
     * @param null $url
     */
    public static function setCurrent($url = null)
    {
        $lang = self::getByUrl($url);
        self::$current = $lang === null ? self::getDefault() : $lang;

        Yii::$app->params['lang_id'] = self::$current->id;
        Yii::$app->language = self::$current->iso;
    }

    /**
     * Получения объекта языка по умолчанию
     */
    public static function get($id)
    {
        return self::findOne($id);
    }

    /**
     * Получения объекта языка по умолчанию
     */
    public static function getDefault()
    {
        $id = Yii::$app->params['lang_id'];
        return self::findOne($id);
    }

    /**
     * Получения объекта языка по буквенному идентификатору
     * @param null $url
     * @return array|null|ActiveRecord
     */
    public static function getByUrl($url = null)
    {
        if ($url === null) {
            return null;
        }

        $lang = Lang::find()
            ->where(['url' => $url])
            ->one();
        if ($lang === null) {
            return null;
        }
        return $lang;
    }

    ####################################################################################################

    public function getModifyIso()
    {
        return str_replace('-', '_', strtolower($this->iso));
    }
}
