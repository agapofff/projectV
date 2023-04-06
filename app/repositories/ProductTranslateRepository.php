<?php

namespace app\repositories;

use app\entities\admin\ProductTranslate;

class ProductTranslateRepository
{
    public function get($id)
    {
        if (!$model = ProductTranslate::findOne($id)) {
            throw new NotFoundException('Model is not found.');
        }
        return $model;
    }

    public function getByCurrencyProductLang($product_id, $lang_id)
    {
        return ProductTranslate::find()
            ->where('product_id = :product_id AND lang_id = :lang_id', [
                'product_id' => $product_id,
                'lang_id' => $lang_id,
            ])
            ->one();
    }

    public function save(ProductTranslate $model)
    {
        if (!$model->save()) {
            throw new \RuntimeException('Saving error.');
        }
        return $model;
    }
}
