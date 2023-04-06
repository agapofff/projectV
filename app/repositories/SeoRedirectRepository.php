<?php

namespace app\repositories;

use app\entities\admin\SeoRedirect;

class SeoRedirectRepository
{
    public function get($id)
    {
        if (!$model = SeoRedirect::findOne($id)) {
            throw new NotFoundException('Model is not found.');
        }
        return $model;
    }

    public function getByFrom($url_from)
    {
        return SeoRedirect::find()
            ->where('url_from = :url_from', [
                'url_from' => $url_from,
            ])
            ->one();
    }

    public function getAll()
    {
        return SeoRedirect::find()
            ->orderBy('id DESC')
            ->all();
    }

    public function save(SeoRedirect $model)
    {
        if (!$model->save()) {
            throw new \RuntimeException('Saving error.');
        }
        return $model;
    }

    public function remove(SeoRedirect $model)
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}
