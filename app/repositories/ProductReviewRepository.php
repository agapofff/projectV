<?php

namespace app\repositories;

use app\entities\admin\ProductReview;

class ProductReviewRepository
{
    public function get($id)
    {
        if (!$model = ProductReview::findOne($id)) {
            throw new NotFoundException('Model is not found.');
        }
        return $model;
    }

    public function getAll($product_id)
    {
        return ProductReview::find()
            ->where('product_id = :product_id', [
                'product_id' => $product_id,
            ])
            ->orderBy('position, id')
            ->all();
    }

    public function save(ProductReview $model)
    {
        if (!$model->save()) {
            throw new \RuntimeException('Saving error.');
        }
        return $model;
    }

    public function updatePosition($id, $position): void
    {
        ProductReview::updateAll([
            'position' => $position,
        ], ['id' => $id]);
    }

    public function remove(ProductReview $model)
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}
