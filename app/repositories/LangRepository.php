<?php

namespace app\repositories;

use app\entities\lang\Lang;

class LangRepository
{
    public function get($id)
    {
        if ($model = Lang::findOne($id)) {
            return $model;
        }

        return false;
    }

    public function getByUrl($url)
    {
        return Lang::find()
            ->where('url = :url', [
                'url' => $url,
            ])
            ->one();
    }

    public function getByIso($iso)
    {
        return Lang::find()
            ->where('iso = :iso', [
                'iso' => $iso,
            ])
            ->one();
    }

    public function getAll()
    {
        return Lang::find()
            ->orderBy('iso')
            ->all();
    }

    public function getAllForTranslators()
    {
        return Lang::find()->alias('l')
            ->where('l.id != 1 AND l.active = 1')
            ->orderBy('iso')
            ->all();
    }

    public function getAllForTranslators2()
    {
        return Lang::find()->alias('l')
            ->where('l.active = 1')
            ->orderBy('iso')
            ->all();
    }

    public function getAllActive()
    {
        return Lang::find()->alias('l')
            ->innerJoin('tbl_countries c', 'c.lang_id = l.id')
            ->innerJoin('tbl_stores s', 's.currency_iso = c.currency_iso')
            ->where(['l.active' => 1])
            ->orderBy('url')
            ->all();
    }

    public function getAllActiveExceptId($id)
    {
        return Lang::find()->alias('l')
            ->innerJoin('tbl_countries c', 'c.lang_id = l.id')
            ->innerJoin('tbl_stores s', 's.currency_iso = c.currency_iso')
            ->where('l.id != :id AND l.active = 1', [
                'id' => $id,
            ])
            ->orderBy('name')
            ->all();
    }

    public function save(Lang $model)
    {
        if (!$model->save()) {
            throw new \RuntimeException('Saving error.');
        }
        return $model;
    }

    public function remove(Lang $model)
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}
