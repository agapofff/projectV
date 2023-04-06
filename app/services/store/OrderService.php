<?php

namespace app\services\store;

use app\entities\store\Order;
use app\repositories\ClientRepository;
use app\repositories\OrderRepository;
use app\repositories\PromoCodeRepository;
use app\services\mail\MailService;
use Yii;
use yii\helpers\Json;
use yii\web\Cookie;

class OrderService
{
    private $clientRepository;
    private $orderRepository;
    private $promoCodeRepository;
    private $mailService;

    public function __construct(
        ClientRepository $clientRepository,
        OrderRepository $orderRepository,
        PromoCodeRepository $promoCodeRepository,
        MailService $mailService
    )
    {
        $this->clientRepository = $clientRepository;
        $this->orderRepository = $orderRepository;
        $this->promoCodeRepository = $promoCodeRepository;
        $this->mailService = $mailService;
    }

    ####################################################################################################

    public function setMemberId(string $member_id): void
    {
        $cookies = Yii::$app->response->cookies;
        $cookies->add(new Cookie([
            'name' => 'member_id',
            'value' => $member_id,
        ]));
    }

    public function getCountProductsInCart(int $order_id): int
    {
        $order = $this->orderRepository->get($order_id);

        $quantity = 0;
        foreach ($order->products as $product) {
            $quantity = $quantity + $product->quantity;
        }

        return $quantity;
    }

    public function recountPrices(Order $order)
    {
        $price_products = 0;
        foreach ($order->products as $orderProduct) {
            $price_products = $price_products + $orderProduct->quantity * $orderProduct->price;
        }

        $price_discount = 0;
        if ($promoCode = $this->promoCodeRepository->getByCode($order->promo_code)) {
            $promo_price_products = 0;
            foreach ($order->products as $orderProduct) {
                if (empty($promoCode->products) || in_array($orderProduct->product_id, explode(',', $promoCode->products))) {
                    $promo_price_products = $promo_price_products + $orderProduct->quantity * $orderProduct->price;
                }
            }
            foreach (explode("\n", $promoCode->value) as $row) {

                $explode = explode(',', $row);
                $price_min = $explode[0];
                $price_max = !empty($explode[1]) ? $explode[1] : '999999999999';
                $value = $explode[2];

                if ($promo_price_products >= $price_min && $promo_price_products <= $price_max) {
                    if ($promoCode->type === 'percent') {
                        $price_discount = $promo_price_products * $value / 100;
                    } elseif ($promoCode->type === 'currency') {
                        $price_discount = $promo_price_products - $value;
                    }
                    break;
                }
            }
            $price_discount = round($price_discount);
        } else {
            $order->editPromoCode(
                null
            );
            $this->orderRepository->save($order);
        }

        $price_delivery = (int) $order->price_delivery;

        $price_total = $price_products - $price_discount + $price_delivery;

        $order->editPrices(
            $price_products,
            $price_discount,
            $price_total
        );
        return $this->orderRepository->save($order);
    }

    public function addPromoCode(int $order_id, $promo_code): void
    {
        $order = $this->orderRepository->get($order_id);

        $code = null;
        if ($promoCode = $this->promoCodeRepository->getByCode($promo_code)) {
            $countUsagePromoCodeCurrentUser = $this->orderRepository->countUsagePromoCodeCurrentUser($order->client_id, $promo_code);
            if ($promoCode->usage_limit_current_user > $countUsagePromoCodeCurrentUser || empty($promoCode->usage_limit_current_user)) {
                $code = $promoCode->code;
            }
        }

        $order->editPromoCode($code);
        $this->orderRepository->save($order);
    }

    public function getProducts(Order $order): array
    {
        $products = [];
        foreach ($order->products as $orderProduct) {
            if ($productSessia = $orderProduct->productSessia) {
                $products[] = [
                    'goods' => $productSessia->id,
                    'quantity' => $orderProduct->quantity,
                ];
            }
        }
        return $products;
    }

    public function getDeliveryInfo($order, $delivery_type_list, $delivery_id): object
    {
        $delivery_value = '';
        $pickup_list = [];
        $delivery_list = [];
        foreach ($delivery_type_list as $item) {
            if ($item->type === 'pickup') {
                $pickup_list[] = $item;
            } else {
                $delivery_list[] = $item;
            }
            if ($item->id === $delivery_id) {
                $delivery_value = $item;
            }
        }

        $delivery_type_list = $order->getDeliveryTypes($pickup_list, $delivery_list);

        return (object) [
            'type_list' => $delivery_type_list,
            'value' => $delivery_value,
        ];
    }


    public function updateCart($order, $form)
    {
        $this->editClient(
            $order->client,
            $form
        );

        return $this->editDelivery(
            $order,
            $form->delivery_type,
            $form->delivery_id,
            $form->price_delivery
        );
    }

    public function editClient($client, $form)
    {
        $client->edit(
            $form->country_id,
            $form->city_id,
            $form->name,
            $form->email,
            $form->phone,
            $form->post_code,
            $form->street,
            $form->home_number,
            $form->room
        );
        $this->clientRepository->save($client);
    }

    public function editDelivery($order, $delivery_type, $delivery_id, $price_delivery)
    {
        $order->editDelivery(
            $delivery_type,
            $delivery_id,
            $price_delivery
        );
        return $this->orderRepository->save($order);
    }

    public function createOrder($order, $orderSessia)
    {
        if (isset($orderSessia->id)) {
            $order->editResponse(
                json_encode($orderSessia, JSON_UNESCAPED_UNICODE)
            );
            $this->orderRepository->save($order);

            if (isset($orderSessia->payment_url)) {
                return (object) [
                    'scenario' => 'redirect',
                    'data' => $orderSessia->payment_url,
                ];
            }
        }

        return (object) [
            'scenario' => 'error',
            'data' => Json::encode($orderSessia),
        ];
    }

    ####################################################################################################################

    public function getByClientId($client_id, $order_id)
    {
        if ($order = $this->orderRepository->getByClientId($order_id, $client_id)) {
            return $order;
        }

        return false;
    }

    public function updateThankYouPage($order, $orderResponse, $orderSessia, $paymentStatus, $status)
    {
        if (!empty($status)) {
            $order->editStatus($status);
            $order = $this->orderRepository->save($order);

            $client = $order->client;

            $this->mailService->sendMail(
                'store/cart/client',
                [
                    'order' => $order,
                    'orderSessia' => $orderSessia,
                    'orderResponse' => $orderResponse,
                    'paymentStatus' => $paymentStatus,
                ],
                null,
                [$client->email => $client->name],
                Yii::t('app', 'Ваш заказ #{order} на сайте Project V', ['order' => $orderSessia->id])
            );
        }

        return $order;
    }
}
