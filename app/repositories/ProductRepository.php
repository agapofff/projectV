<?php

namespace app\repositories;

use app\entities\admin\Product;

class ProductRepository
{
    public function get($id)
    {
        return Product::findOne($id);
    }

    public function getByVendorCode($sessia_vendor_codes)
    {
        return Product::find()
            ->where(['sessia_vendor_code' => $sessia_vendor_codes])
            ->one();
    }

    public function getBySessiaImg($sessia_img)
    {
        return Product::find()
            ->where(['sessia_img' => $sessia_img])
            ->one();
    }

    public function getAll()
    {
        return Product::find()
            ->orderBy('id, sessia_title')
            ->all();
    }

    public function getAllByVendorCodes($sessia_vendor_codes)
    {
        return Product::find()
            ->where('sessia_vendor_code IN (' . $sessia_vendor_codes . ')')
            ->orderBy('collection, position')
            ->all();
    }

    public function getAllByCategory($category)
    {
        return Product::find()->alias('p') // p
            ->innerJoinWith(['translateByLangId']) // pt
            ->where('p.category = :category AND (pt.title != "" OR pt.title IS NOT NULL)', [
                'category' => $category,
            ])
            ->orderBy('p.collection, p.position')
            ->all();
    }

    public function save(Product $model)
    {
        if (!$model->save()) {
            throw new \RuntimeException('Saving error.');
        }
        return $model;
    }

    public function updatePosition($id, $position): void
    {
        Product::updateAll([
            'position' => $position,
        ], ['id' => $id]);
    }

    public function remove(Product $model)
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }

    public function getAllActive()
    {
        return Product::find()->alias('p')
            ->select('
                p.*
            ')
            ->innerJoinWith(['translateByLangId'])  // pt.*
            ->where('p.active = 1')
            ->orderBy('p.position, p.id')
            ->all();
    }

    public function search($query, $params, $currency_iso, $store_id)
    {
        return Product::find()->alias('p')
            ->distinct('pt.product_id')
            ->select('p.*')
            ->innerJoin('tbl_products_translate pt', 'p.id = pt.product_id')
            ->innerJoin('tbl_products_sessia ps', 'p.id = ps.product_id')
            ->where('ps.store_id = :store_id AND ps.price_iso = :price_iso' . $query, array_merge($params, [
                'store_id' => $store_id,
                'price_iso' => $currency_iso,
            ]))
            ->orderBy('p.code')
            ->limit(6)
            ->all();
    }
}
