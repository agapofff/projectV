<?php

namespace app\repositories;

use app\entities\store\PromoCode;

class PromoCodeRepository
{
    public function get(int $id)
    {
        return $this->getBy(['id' => $id]);
    }

    public function getByCode($code)
    {
        return $this->getBy('code = :code AND date_start <= STR_TO_DATE(:date, "%Y-%m-%d %H:%i:%s") AND date_end >= STR_TO_DATE(:date, "%Y-%m-%d %H:%i:%s") AND (usage_limit IS NULL OR usage_limit >= number_of_uses) AND active = 1', [
            'code' => $code,
            'date' => date('Y-m-d H:i:s'),
        ]);
    }

    private function getBy($condition, $params = [])
    {
        return PromoCode::find()
            ->where($condition, $params)
            ->limit(1)
            ->one();
    }

    public function save(PromoCode $model)
    {
        if (!$model->save()) {
            throw new \RuntimeException('Saving error.');
        }
        return $model;
    }
}
