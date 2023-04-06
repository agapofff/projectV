<?php

namespace app\repositories;

use app\entities\admin\Currency;

class CurrencyRepository
{
    public function get($id)
    {
        if ($model = Currency::findOne($id)) {
            return $model;
        }

        return false;
    }

    public function getByIso($iso)
    {
        return Currency::find()
            ->where('iso = :iso', [
                'iso' => $iso,
            ])
            ->one();
    }

    public function getAll() : array
    {
        return Currency::find()
            ->orderBy('iso')
            ->all();
    }

    public function create(Currency $model) : Currency
    {
        if (!$model->save()) {
            throw new \RuntimeException('Saving error.');
        }
        return $model;
    }

    public function save(Currency $model) : Currency
    {
        if (!$model->save()) {
            throw new \RuntimeException('Saving error.');
        }
        return $model;
    }

    public function remove(Currency $model) : void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}
