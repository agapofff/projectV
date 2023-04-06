<?php

namespace app\repositories;

use app\entities\store\OrderProduct;

class OrderProductRepository
{
    public function get($id)
    {
        if (!$model = OrderProduct::findOne($id)) {
            throw new NotFoundException('Model is not found.');
        }
        return $model;
    }

    public function hasProductInOrder($order_id, $product_id)
    {
        return OrderProduct::find()
            ->where('order_id = :order_id AND product_id = :product_id', [
                'order_id' => $order_id,
                'product_id' => $product_id,
            ])
            ->one();
    }

    public function getAllByHash($hash)
    {
        return OrderProduct::find()
            ->where('hash = :hash', [
                'hash' => $hash,
            ])
            ->all();
    }

    public function getAll()
    {
        return OrderProduct::find()
            ->orderBy('id DESC')
            ->all();
    }

    public function save(OrderProduct $model): OrderProduct
    {
        if (!$model->save()) {
            throw new \RuntimeException('Saving error.');
        }
        return $model;
    }

    public function updateQuantity($hash, $product_id, $quantity): void
    {
        OrderProduct::updateAll([
            'quantity' => $quantity,
        ], [
            'hash' => $hash,
            'product_id' => $product_id,
        ]);
    }

    public function delete($model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}
