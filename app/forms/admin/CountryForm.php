<?php

namespace app\forms\admin;

use Yii;
use yii\base\Model;

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
 * @property int post_code
 * @property int active
 * @property int created_at
 * @property int updated_at
 */
class CountryForm extends Model
{
    public $id;
    public $domain;
    public $title;
    public $iso;
    public $lang_id;
    public $languages;
    public $currency_iso;
    public $store_id;
    public $phone_code;
    public $phone_mask;
    public $post_code;
    public $active;
    public $created_at;
    public $updated_at;

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'domain' => Yii::t('admin', 'Домен'),
            'title' => Yii::t('admin', 'Название'),
            'iso' => Yii::t('admin', 'ISO'),
            'lang_id' => Yii::t('admin', 'Основной язык'),
            'languages' => Yii::t('admin', 'Языки'),
            'currency_iso' => Yii::t('admin', 'Валюта страны'),
            'store_id' => Yii::t('admin', 'Основной магазин'),
            'phone_code' => Yii::t('admin', 'Телефонный код'),
            'phone_mask' => Yii::t('admin', 'Телефонная маска'),
            'post_code' => Yii::t('admin', 'Индекс'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['title', 'iso', 'phone_code', 'phone_mask'], 'required'],
            [['domain', 'title', 'iso', 'languages', 'phone_code', 'phone_mask'], 'trim'],
            [['iso'], 'string', 'min' => 2, 'max' => 3],
            [['lang_id', 'store_id'], 'integer'],
            [['domain', 'lang_id', 'languages', 'currency_iso', 'store_id', 'post_code'], 'safe'],
            [['phone_code'], 'string', 'min' => 2, 'max' => 4],
        ];
    }
}
