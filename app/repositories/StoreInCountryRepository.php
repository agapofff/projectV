<?php

namespace app\repositories;

use app\entities\admin\StoreInCountry;

class StoreInCountryRepository
{
    public function get($id) : StoreInCountry
    {
        if (!$model = StoreInCountry::findOne($id)) {
            throw new NotFoundException('Model is not found.');
        }
        return $model;
    }

    public function getByCountryId($country_id)
    {
        $model = StoreInCountry::find()
            ->where('country_id = :country_id', [
                'country_id' => $country_id,
            ])
            ->one();
        if ($model) {
            return $model;
        }

        return false;
    }

    public function checkRelation($store_id, $country_id)
    {
        $model = StoreInCountry::find()
            ->where('store_id = :store_id AND country_id = :country_id', [
                'store_id' => $store_id,
                'country_id' => $country_id,
            ])
            ->one();
        if ($model) {
            return $model;
        }

        return false;
    }

    public function create(StoreInCountry $model) : StoreInCountry
    {
        if (!$model->save()) {
            throw new \RuntimeException('Saving error.');
        }
        return $model;
    }

    public function deleteAll()
    {
        StoreInCountry::deleteAll();
    }

    public function save(StoreInCountry $model) : StoreInCountry
    {
        if (!$model->save()) {
            throw new \RuntimeException('Saving error.');
        }
        return $model;
    }

    public function remove(StoreInCountry $model) : void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}
