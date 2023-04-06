<?php

namespace app\entities\admin;

use Yii;
use yii\db\ActiveRecord;

/**
 * @property int id
 * @property string type
 * @property string title
 * @property string currency_iso
 * @property string created_at
 * @property string updated_at
 */
class Store extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%stores}}';
    }

    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('admin', 'ID'),
            'type' => Yii::t('admin', 'Тип'),
            'title' => Yii::t('admin', 'Название'),
            'currency_iso' => Yii::t('admin', 'Валюта ISO'),
            'created_at' => Yii::t('admin', 'Created date'),
            'updated_at' => Yii::t('admin', 'Updated date'),
        ];
    }

    ####################################################################################################################

    public function getCountries()
    {
        return self::find()->alias('s')
            ->select('c.*')
            ->innerJoinWith([
                'storeInCountries sic' => function($q) {
                    $q->innerJoinWith('country c', 'c.id = sic.country_id');
                },
            ])
            ->where([
                's.id' => $this->id,
            ])
            ->orderBy('c.title')
            ->all();
    }

    public function getStoreInCountries()
    {
        return $this->hasMany(StoreInCountry::class, ['store_id' => 'id']);
    }

    public function getProductsSessia()
    {
        return $this->hasMany(ProductSessia::class, ['store_id' => 'id'])
            ->where('active = 1')
            ->orderBy('position');
    }

    public function getStoresExceptCurrentId()
    {
        return self::find()
            ->where('id != :id', [
                'id' => $this->id,
            ])
            ->orderBy('id')
            ->all();
    }

    ####################################################################################################################

    public static function create()
    {
        return new self();
    }

    public function edit(
        $id,
        $type,
        $title,
        $currency_iso
    )
    {
        $this->id = $id;
        $this->type = $type;
        $this->title = $title;
        $this->currency_iso = $currency_iso;
    }

    public function getLabel()
    {
        return $this->currency_iso . ' ' . $this->title . ' ' . $this->id;
    }

    public static function getTypeList()
    {
        return [
            'not-mlm' => Yii::t('admin', 'Не МЛМ'),
        ];
    }

    public static function getAuthorisationList()
    {
        return [
            'not-mlm' => 'Bearer YTQyOTNjNGJiZTc1MjllMTY2ZWM2ODc2ZjRlOGEzODBlODgwNjQ2Njk5YzY2YmI0ODk1NzQ4MWNlODI2YzczNw',
        ];
    }

    public static function getTypeDefault()
    {
        return 'not-mlm';
    }

    public function getType()
    {
        return !empty($this->type) ? self::getTypeList()[$this->type] : '';
    }

    public static function getAuthorisation($type)
    {
        return self::getAuthorisationList()[$type];
    }
}
