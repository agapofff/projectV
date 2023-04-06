<?php

namespace app\services\admin;

use app\entities\admin\Product;
use app\entities\admin\ProductSessia;
use app\repositories\ProductRepository;
use app\repositories\ProductSessiaRepository;
use app\repositories\StoreRepository;
use Yii;

class ProductSessiaService
{
    private $sessiaService;
    private $storeRepository;
    private $productRepository;
    private $productSessiaRepository;

    public function __construct(
        SessiaService $sessiaService,
        StoreRepository $storeRepository,
        ProductRepository $productRepository,
        ProductSessiaRepository $productSessiaRepository
    )
    {
        $this->sessiaService = $sessiaService;
        $this->storeRepository = $storeRepository;
        $this->productRepository = $productRepository;
        $this->productSessiaRepository = $productSessiaRepository;
    }

    public function import()
    {
        $this->productSessiaRepository->deleteAll();

        $stores = $this->storeRepository->getAll();
        foreach ($stores as $store) {
            if ($catalog = $this->sessiaService->getCatalog($store->id)) {
                foreach ($catalog as $key) {
                    foreach ($key['goods_list'] as $item) {
                        if (in_array($item['vendor_code'], Yii::$app->params['vendor_codes'])) {
                            if ($product = $this->productRepository->getByVendorCode($item['vendor_code'])) {
                                $product->updateFromSessia(
                                    $item['name'],
                                    $item['images'][0]['path']
                                );
                            } else {
                                $product = Product::createFromSessia(
                                    $item['name'],
                                    $item['vendor_code'],
                                    $item['images'][0]['path']
                                );
                            }
                            $product = $this->productRepository->save($product);

                            $productSessia = ProductSessia::create(
                                $item['id'],
                                $store->id,
                                $product->id,
                                $item['price'],
                                $store->currency_iso,
                                $item['sort']
                            );
                            $this->productSessiaRepository->save($productSessia);
                        }
                    }
                }
            }
        }
    }

    public function importProduct(int $product_id)
    {
        if ($item = $this->sessiaService->getProduct($product_id)[0]) {
            if (!$this->productRepository->getByVendorCode($item['vendor_code'])) {
                $product = Product::createFromSessia(
                    $item['name'],
                    $item['vendor_code'],
                    $item['images'][0]['path']
                );
                if ($product = $this->productRepository->save($product)) {
                    $productSessia = ProductSessia::create(
                        $item['id'],
                        $item['store']['id'],
                        $product->id,
                        $item['price'],
                        $item['store']['currency_iso_code'],
                        $item['sort']
                    );
                    $this->productSessiaRepository->save($productSessia);
                }
            }
        }
    }
}
