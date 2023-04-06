<?php

namespace app\repositories;

use app\entities\store\Client;

class ClientRepository
{
    public function get($id)
    {
        return $this->getBy(['id' => $id]);
    }

    public function getByHash($hash)
    {
        return $this->getBy(['hash' => $hash]);
    }

    private function getBy(array $condition)
    {
        return Client::find()
            ->where($condition)
            ->limit(1)
            ->one();
    }

    public function save(Client $model)
    {
        if (!$model->save()) {
            throw new \RuntimeException('Saving error.');
        }
        return $model;
    }
}
