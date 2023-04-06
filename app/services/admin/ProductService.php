<?php

namespace app\services\admin;

use app\repositories\ProductRepository;
use app\repositories\ProductSessiaRepository;
use Yii;

class ProductService
{
    private $productRepository;
    private $productSessiaRepository;

    public function __construct(
        ProductRepository $productRepository,
        ProductSessiaRepository $productSessiaRepository
    )
    {
        $this->productRepository = $productRepository;
        $this->productSessiaRepository = $productSessiaRepository;
    }

    public function updatePosition($items)
    {
        $i = 0;
        while (isset($items[$i])) {
            $id = (int)$items[$i];
            $position = $i;
            $this->productRepository->updatePosition($id, $position);
            $i++;
        }
    }

    public function edit($model, $form)
    {
        $model->edit(
            $form->sessia_vendor_code,
            $form->category,
            $form->collection,
            empty($form->sex) ? '' : implode(',', $form->sex),
            empty($form->problem) ? '' : implode(',', $form->problem),
            $form->active
        );
        $this->productRepository->save($model);
    }

    public function combine($current_id, $id)
    {
        $this->productSessiaRepository->updateAllByProductId($current_id, $id);

        $product = $this->productRepository->get($current_id);
        $this->productRepository->remove($product);
    }

    public function productService($value)
    {
        return $this->productRepository->search($value);
    }

    public function search($term)
    {
        $symbols = mb_strlen($term, 'UTF-8');

        $query = ' AND (REPLACE(pt.title, "&nbsp;", " ") LIKE :term OR pt.description LIKE :term)';
        $params = ['term' => '%' . $term . '%'];

        if ($symbols >= 1) {
            return $this->productRepository->search(
                $query,
                $params,
                Yii::$app->params['currency'],
                Yii::$app->params['store_id']
            );
        }
        return [];
    }
}
