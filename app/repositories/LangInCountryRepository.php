<?php

namespace app\repositories;

use app\entities\admin\LangInCountry;

class LangInCountryRepository
{
    public function get($id)
    {
        if ($model = LangInCountry::findOne($id)) {
            return $model;
        }

        return false;
    }

    public function updatePosition($id, $position): void
    {
        LangInCountry::updateAll([
            'position' => $position,
        ], ['id' => $id]);
    }

    public function remove(LangInCountry $sponsor)
    {
        if (!$sponsor->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }

    public function save(LangInCountry $model)
    {
        if (!$model->save()) {
            throw new \RuntimeException('Saving error.');
        }
        return $model;
    }
}
