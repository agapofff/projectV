<?php

namespace app\repositories;

use app\entities\admin\SeoMetadata;

class SeoMetadataRepository
{
    public function get($id)
    {
        if (!$model = SeoMetadata::findOne($id)) {
            throw new NotFoundException('Model is not found.');
        }
        return $model;
    }

    public function getByLink($link)
    {
        return SeoMetadata::find()
            ->where('link = :link', [
                'link' => $link,
            ])
            ->one();
    }

    public function getAll()
    {
        return SeoMetadata::find()
            ->orderBy('id DESC')
            ->all();
    }

    public function save(SeoMetadata $model)
    {
        if (!$model->save()) {
            throw new \RuntimeException('Saving error.');
        }
        return $model;
    }

    public function remove(SeoMetadata $model)
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}
