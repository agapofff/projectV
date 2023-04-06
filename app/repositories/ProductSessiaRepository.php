<?php

namespace app\repositories;

use app\entities\admin\ProductSessia;

class ProductSessiaRepository
{
    public function get($id)
    {
        if ($model = ProductSessia::findOne($id)) {
            return $model;
        }

        return false;
    }

    public function getParent($store_id, $product_id)
    {
        return ProductSessia::find()
            ->where('store_id = :store_id AND product_id = :product_id', [
                'store_id' => $store_id,
                'product_id' => $product_id,
            ])
            ->one();
    }

    public function getAll()
    {
        return ProductSessia::find()
            ->orderBy('currency_iso, id')
            ->all();
    }

    public function getDistinctProductId($ids)
    {
        return ProductSessia::find()
            ->distinct('product_id')
            ->where(['in', 'id', $ids])
            ->one();
    }

    public function getAllActive()
    {
        return ProductSessia::find()
            ->where('active = 1')
            ->orderBy('id')
            ->all();
    }

    public function updateAllByProductId($current_product_id, $product_id)
    {
        ProductSessia::updateAll([
            'product_id' => $product_id,
        ], ['product_id' => $current_product_id]);
    }

    public function save(ProductSessia $model)
    {
        if (!$model->save()) {
            throw new \RuntimeException('Saving error.');
        }
        return $model;
    }

    public function deleteAll()
    {
        return ProductSessia::deleteAll();
    }

    public function deleteExceptAllId(array $ids)
    {
        ProductSessia::deleteAll(['AND', 'id > 0', ['NOT IN', 'store_id', $ids]]);
    }

    public function remove(ProductSessia $model)
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}
