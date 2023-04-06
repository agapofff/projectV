<?php

namespace app\services\admin;

use app\entities\admin\ProductTranslate;
use app\repositories\ProductTranslateRepository;

class ProductTranslateService
{
    private $productTranslateRepository;

    public function __construct(
        ProductTranslateRepository $productTranslateRepository
    )
    {
        $this->productTranslateRepository = $productTranslateRepository;
    }

    public function search($term)
    {
        if (mb_strlen($term, 'UTF-8') >= 1) {
            return $this->productTranslateRepository->search($term);
        }
        return [];
    }

    public function create(
        $product_id,
        $lang_id
    )
    {
        $productTranslate = ProductTranslate::create(
            $product_id,
            $lang_id
        );
        return $this->productTranslateRepository->save($productTranslate);
    }

    public function edit(
        $id,
        $title,
        $description,
        $properties,
        $benefits,
        $video,
        $main_components,
        $composition,
        $recommendations,
        $dosage,
        $storage,
        $issue
    )
    {
        $productTranslate = $this->productTranslateRepository->get($id);
        $productTranslate->edit(
            $title,
            $description,
            $properties,
            $benefits,
            $video,
            $main_components,
            $composition,
            $recommendations,
            $dosage,
            $storage,
            $issue
        );
        $this->productTranslateRepository->save($productTranslate);
    }
}
