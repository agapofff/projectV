<?php

namespace app\repositories;

use app\entities\admin\ProductImg;

class ProductImgRepository
{
    public function get($id)
    {
        if (!$model = ProductImg::findOne($id)) {
            throw new NotFoundException('Model is not found.');
        }
        return $model;
    }
    
    public function getByProductIdAndCurrencyIso($product_id)
    {
        return ProductImg::find()
            ->where([
                'product_id' => $product_id,
            ])
            ->orderBy('position, id')
            ->one();
    }

    public function getAll($product_id)
    {
        return ProductImg::find()
            ->where('product_id = :product_id', [
                'product_id' => $product_id,
            ])
            ->orderBy('position, id')
            ->all();
    }

    public function save(ProductImg $model)
    {
        if (!$model->save()) {
            throw new \RuntimeException('Saving error.');
        }
        return $model;
    }

    public function updatePosition($id, $position): void
    {
        ProductImg::updateAll([
            'position' => $position,
        ], ['id' => $id]);
    }

    public function remove(ProductImg $model)
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}
