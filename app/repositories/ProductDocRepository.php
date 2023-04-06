<?php

namespace app\repositories;

use app\entities\admin\ProductDoc;

class ProductDocRepository
{
    public function get($id)
    {
        if (!$model = ProductDoc::findOne($id)) {
            throw new NotFoundException('Model is not found.');
        }
        return $model;
    }

    public function getAll($product_id, $lang_id)
    {
        return ProductDoc::find()
            ->where('product_id = :product_id AND lang_id = :lang_id', [
                'product_id' => $product_id,
                'lang_id' => $lang_id,
            ])
            ->orderBy('position, id')
            ->all();
    }

    public function save(ProductDoc $model)
    {
        if (!$model->save()) {
            throw new \RuntimeException('Saving error.');
        }
        return $model;
    }

    public function updatePosition($id, $position): void
    {
        ProductDoc::updateAll([
            'position' => $position,
        ], ['id' => $id]);
    }

    public function remove(ProductDoc $model)
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}
