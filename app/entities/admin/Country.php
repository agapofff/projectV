<?php

namespace app\entities\admin;

use app\entities\lang\Lang;
use Yii;
use yii\db\ActiveRecord;

/**
 * @property int id
 * @property string domain
 * @property string title
 * @property string iso
 * @property int lang_id
 * @property string languages
 * @property string currency_iso
 * @property string store_id
 * @property string phone_code
 * @property string phone_mask
 * @property string post_code
 * @property int active
 * @property string created_at
 * @property string updated_at
 */
class Country extends ActiveRecord
{
    public $url;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%countries}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('admin', 'ID'),
            'domain' => Yii::t('admin', 'Домен'),
            'title' => Yii::t('admin', 'Название'),
            'iso' => Yii::t('admin', 'ISO'),
            'lang_id' => Yii::t('admin', 'Основной язык'),
            'languages' => Yii::t('admin', 'Языки'),
            'currency_iso' => Yii::t('admin', 'Валюта'),
            'store_id' => Yii::t('admin', 'Основной магазин'),
            'phone_code' => Yii::t('admin', 'Телефонный код'),
            'phone_mask' => Yii::t('admin', 'Телефонная маска'),
            'post_code' => Yii::t('admin', 'Индекс'),
            'active' => Yii::t('admin', 'Активно'),
            'created_at' => Yii::t('admin', 'Created date'),
            'updated_at' => Yii::t('admin', 'Updated date'),
        ];
    }

    ####################################################################################################################

    public function getStores()
    {
        return self::find()->alias('c')
            ->select('s.*')
            ->innerJoinWith([
                'storeInCountries sic' => function($q) {
                    $q->innerJoin('tbl_stores s', 's.id = sic.store_id');
                },
            ])
            ->where('c.id = :id AND c.active = 1', [
                'id' => $this->id,
            ])
            ->orderBy('s.id')
            ->all();
    }

    public function getStoreInCountries()
    {
        return $this->hasMany(StoreInCountry::class, ['country_id' => 'id']);
    }

    public function getLang()
    {
        return $this->hasOne(Lang::class, ['id' => 'lang_id'])->alias('l');
    }

    public function getCurrency()
    {
        return $this->hasOne(Currency::class, ['iso' => 'currency_iso'])->alias('currency');
    }

    public function getStore()
    {
        return $this->hasOne(Store::class, ['iso' => 'currency_iso'])->alias('store');
    }

    public function getStoreByStoreId()
    {
        return $this->hasOne(Store::class, ['id' => 'store_id'])->alias('s')
            ->where(['s.id' => Yii::$app->params['store_id']]);
    }

    public static function getDefaultLang()
    {
        $model = self::find()
            ->where(['domain' => $_SERVER['SERVER_NAME']])
            ->one();
        if ($model) {
            return $model->lang_id;
        }

        return 1;
    }

    ####################################################################################################################

    public static function create(
        $id,
        $title,
        $iso,
        $phone_code,
        $phone_mask
    ): self
    {
        $model = new self();
        $model->id = $id;
        $model->title = $title;
        $model->iso = $iso;
        $model->phone_code = $phone_code;
        $model->phone_mask = $phone_mask;
        $model->active = 1;

        return $model;
    }

    public function updateActive($active)
    {
        $this->active = $active;
    }

    public function edit(
        $domain,
        $title,
        $iso,
        $lang_id,
        $languages,
        $currency_iso,
        $store_id,
        $phone_code,
        $phone_mask,
        $post_code
    )
    {
        $this->domain = $domain;
        $this->title = $title;
        $this->iso = $iso;
        $this->lang_id = $lang_id;
        $this->languages = $languages;
        $this->currency_iso = $currency_iso;
        $this->store_id = $store_id;
        $this->phone_code = $phone_code;
        $this->phone_mask = $phone_mask;
        $this->post_code = $post_code;
    }

    ####################################################################################################################

    public function getLocalTitle()
    {
        $language = Yii::$app->language;

        if (!preg_match("(\[" . $language . "\])", $this->title)) {
            $language = 'en-US';
        }

        $title = $this->title;
        $arr = explode("<-!-!->", preg_replace('#(\[(\w){2}-(\w){2}\])#i', '<-!-!->\\0', $this->title));
        foreach ($arr as $val) {
            if (preg_match("(\[" . $language . "\])", $val)) {
                $title = trim(substr($val, strlen("[" . $language . "]")));
                break;
            }
        }

        return $title;
    }
}
