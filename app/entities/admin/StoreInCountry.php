<?php

namespace app\entities\admin;

use yii\db\ActiveRecord;

/**
 * @property int id
 * @property int store_id
 * @property int country_id
 * @property string created_at
 * @property string updated_at
 */
class StoreInCountry extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%store_in_countries}}';
    }

    public function getStore()
    {
        return $this->hasOne(Store::class, ['id' => 'store_id']);
    }

    public function getCountry()
    {
        return $this->hasOne(Country::class, ['id' => 'country_id'])
            ->where('active = 1');
    }

    public static function create(
        $store_id,
        $country_id
    ): self
    {
        $model = new self();
        $model->store_id = $store_id;
        $model->country_id = $country_id;

        return $model;
    }
}
