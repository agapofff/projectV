<?php

namespace app\repositories;

use app\entities\admin\Country;

class CountryRepository
{
    public function get($id)
    {
        if ($model = Country::findOne($id)) {
            return $model;
        }

        return false;
    }

    public function getByIdAndNotNullDomain($id)
    {
        return Country::find()
            ->where('id = :id AND (domain IS NOT NULL OR domain != "")', [
                'id' => $id,
            ])
            ->one();
    }

    public function getByDomain($domain)
    {
        return Country::find()
            ->where('domain = :domain', [
                'domain' => $domain,
            ])
            ->one();
    }

    public function getByIso($iso)
    {
        return Country::find()
            ->where(['iso' => $iso])
            ->one();
    }

    public function getAll() : array
    {
        return Country::find()
            ->orderBy('id DESC')
            ->all();
    }

    public function getAllActiveExceptCurrent($country_id) : array
    {
        return Country::find()->alias('c')
            ->innerJoin('tbl_langs l', 'l.id = c.lang_id')
            ->innerJoin('tbl_stores s', 's.currency_iso = c.currency_iso')
            ->where('c.domain != "" AND c.active = 1 AND c.id != :country_id', [
                'country_id' => $country_id,
            ])
            ->orderBy('c.title')
            ->all();
    }

    public function create(Country $model) : Country
    {
        if (!$model->save()) {
            throw new \RuntimeException('Saving error.');
        }
        return $model;
    }

    public function save(Country $model) : Country
    {
        if (!$model->save()) {
            throw new \RuntimeException('Saving error.');
        }
        return $model;
    }

    public function deactivate()
    {
        return Country::updateAll(['active' => 0]);
    }

    public function updateActive($id)
    {
        return Country::updateAll(['active' => 1], ['id' => $id]);
    }

    public function remove(Country $model) : void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}

/**
 *

select
s.id, -- ID магазина
s.currency_iso -- Валюта магазина

from tbl_countries c
join tbl_store_in_countries sc on sc.country_id = c.id
join tbl_stores s on s.id = sc.store_id

where c.id = 1

 *

select
sc.store_id -- ID магазина

from tbl_countries c
join tbl_store_in_countries sc on sc.country_id = c.id

where c.id = 1

 *
 */
