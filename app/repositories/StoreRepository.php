<?php

namespace app\repositories;

use app\entities\admin\Store;

class StoreRepository
{
    public function get($id)
    {
        if (!$model = Store::findOne($id)) {
            throw new NotFoundException('Model is not found.');
        }
        return $model;
    }

    public function getByCurrencyIso($currency_iso)
    {
        return Store::find()
            ->where('currency_iso = :currency_iso', [
                'currency_iso' => $currency_iso,
            ])
            ->one();
    }

    public function getAll()
    {
        return Store::find()
            ->orderBy('currency_iso, id')
            ->all();
    }

    public function getAllCurrencyIso()
    {
        return Store::find()
            ->distinct('currency_iso')
            ->select('currency_iso')
            ->orderBy('currency_iso')
            ->all();
    }

    public function save(Store $model)
    {
        if (!$model->save()) {
            throw new \RuntimeException('Saving error.');
        }
        return $model;
    }

    public function updatePosition($id, $position): void
    {
        Store::updateAll([
            'position' => $position,
        ], ['id' => $id]);
    }

    public function remove(Store $model)
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}
