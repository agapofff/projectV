<?php

namespace app\components;

use app\entities\store\Order;
use app\entities\store\Client;
use app\repositories\ClientRepository;
use app\repositories\OrderRepository;
use Yii;
use yii\web\Cookie;

class ClientBootstrap
{
    public function __construct()
    {
        $clientRepository = new ClientRepository();
        if ($hash = Yii::$app->request->cookies->getValue('client')) {
            $client = $clientRepository->getByHash($hash);
        }

        if (!isset($client->id)) {
            $client = $this->createClient();
        }

        $order = $client->order;
        if (!$order) {
            $order = $this->createOrder($client->id);
        }

        Yii::$app->params['client_id'] = $client->id;
        Yii::$app->params['order_id'] = $order->id;
    }

    public function createClient(): Client
    {
        $client = Client::create();
        $clientRepository = new ClientRepository();
        $client = $clientRepository->save($client);
        $this->setCookieClient($client->hash);

        return $client;
    }

    public function createOrder(
        $client_id
    ): Order
    {
        $order = Order::create($client_id);
        $orderRepository = new OrderRepository();

        return $orderRepository->save($order);
    }

    public function setCookieClient(string $hash): void
    {
        $cookies = Yii::$app->response->cookies;
        $cookies->add(new Cookie([
            'name' => 'client',
            'value' => $hash,
        ]));
    }

    public function getCookieClient()
    {
        $cookies = Yii::$app->request->cookies;
        if ($cookies->has('client')) {
            return $cookies->getValue('client');
        }
        return false;
    }
}
