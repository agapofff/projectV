<?php

namespace app\services\store;

use app\entities\store\OrderProduct;
use app\repositories\OrderProductRepository;
use app\repositories\OrderRepository;
use app\repositories\ProductRepository;

class OrderProductService
{
    private $orderProductRepository;
    private $productRepository;
    private $orderRepository;

    public function __construct(
        OrderProductRepository $orderProductRepository,
        ProductRepository $productRepository,
        OrderRepository $orderRepository
    )
    {
        $this->orderProductRepository = $orderProductRepository;
        $this->productRepository = $productRepository;
        $this->orderRepository = $orderRepository;
    }

    ####################################################################################################################

    public function plus($order, int $product_id)
    {
        // Проверяем, что товар существует
        if ($product = $this->productRepository->get($product_id)) {
            // Проверяем, что товар существует в этой валюте
            if ($sessia = $product->sessiaByCurrencyIso) {

                $orderProduct = $this->orderProductRepository->hasProductInOrder($order->id, $product->id);
                if (!$orderProduct) {
                    // Если товара в корзине пользователя ещё нет, то добавляем товар в корзину
                    $orderProduct = OrderProduct::create(
                        $order->id,
                        $product->id,
                        1,
                        $sessia->price_value,
                        $sessia->price_iso
                    );
                } else {
                    // Если нажали повторно кнопку Купить, то увеличиваем кол-во этого товара в корзине
                    $orderProduct->editQuantity($orderProduct->quantity + 1);
                }
                $orderProduct = $this->orderProductRepository->save($orderProduct);

                return $orderProduct->quantity;
            }
        }

        return 0;
    }

    public function minus($order, int $product_id)
    {
        // Проверяем, что товар существует
        if ($product = $this->productRepository->get($product_id)) {

            $orderProduct = $this->orderProductRepository->hasProductInOrder($order->id, $product->id);
            if ($orderProduct) {
                if ($orderProduct->quantity - 1 >= 1) {
                    $orderProduct->editQuantity($orderProduct->quantity - 1);
                    $orderProduct = $this->orderProductRepository->save($orderProduct);

                    return $orderProduct->quantity;
                } else {
                    $this->orderProductRepository->delete($orderProduct);

                    return 0;
                }
            }
        }

        return 0;
    }

    public function changeValue($order, int $product_id, int $value)
    {
        // Проверяем, что товар существует
        if ($product = $this->productRepository->get($product_id)) {

            $orderProduct = $this->orderProductRepository->hasProductInOrder($order->id, $product->id);
            if ($orderProduct) {
                $orderProduct->editQuantity($value);
                $orderProduct = $this->orderProductRepository->save($orderProduct);
                return $orderProduct->quantity;
            }
        }
    }

    public function remove($order, int $product_id)
    {
        // Проверяем, что товар существует
        if ($product = $this->productRepository->get($product_id)) {

             $orderProduct = $this->orderProductRepository->hasProductInOrder($order->id, $product->id);
             if ($orderProduct) {
                 $this->orderProductRepository->delete($orderProduct);

                 return true;
             }
        }

        return false;
    }
}
