<?php

namespace app\repositories;

use app\entities\store\Order;

class OrderRepository
{
    public function get($id)
    {
        if (!$model = Order::findOne($id)) {
            throw new NotFoundException('Model is not found.');
        }
        return $model;
    }

    public function getByClientId($id, $client_id)
    {
        return Order::find()
            ->where(['id' => $id, 'client_id' => $client_id, 'status' => 'new'])
            //->where(['id' => $id])
            ->limit(1)
            ->one();
    }

    public function countUsagePromoCodeCurrentUser($client_id, $promo_code)
    {
        return Order::find()
            ->where(['client_id' => $client_id, 'promo_code' => $promo_code, 'status' => 'success'])
            ->limit(1)
            ->count();
    }

    public function save(Order $model)
    {
        if (!$model->save(false)) {
            throw new \RuntimeException('Saving error.');
        }
        return $model;
    }

    public function remove(Order $model)
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}
