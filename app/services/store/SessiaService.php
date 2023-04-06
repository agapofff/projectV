<?php

namespace app\services\store;

use Yii;
use yii\helpers\Json;
use linslin\yii2\curl;

class SessiaService
{
    const SESSIA_URL = 'https://api.sessia.com/api';
    //const CMS_URL = 'https://cms.freedomgroupint.com/api';

    ####################################################################################################################

    public function getGeodataByIp($ip)
    {
        return $this->getResponse(
            'GET',
            '/country/identify',
            [
                'source' => 'geo_ip',
                'ip' => $ip,
            ]
        );
    }

    public function getCities($country_id, $lang_id, $limit = '', $term = '')
    {
        $cities = $this->getResponse(
            'GET',
            '/directory/cities/' . $country_id,
            array_filter([
                'lang' => $lang_id,
                'limit' => $limit,
                'q' => $term,
            ])
        );

        ini_set('memory_limit', '-1');

        $arr = [];
        if ($cities) {
            foreach ($cities as $city) {
                $arr[] = (object) [
                    'id' => $city->id,
                    'name' => $city->ru_name,
                ];
            }
        }

        return $arr;
    }

    public function getDeliveryList($country, $city, $lang_id, $products, $currency)
    {
        $deliveryList = $this->getResponse(
            'POST',
            '/market/delivery-cost',
            array_filter([
                'country' => $country,
                'city' => $city,
                'lang_id' => $lang_id,
                'products' => $products,
            ])
        );

        $arr = [];
        foreach ($deliveryList as $item) {
            $arr[] = (object) [
                'id' => (int) $item->id,
                'type' => $item->delivery_type->pickup ? 'pickup' : 'delivery',
                'title' => stristr($item->delivery_type->delivery_service->name, 'CDEK')
                    ? 'CDEK'
                    : $item->delivery_type->delivery_service->name,
                'params' => isset($item->delivery_time_from)
                    ? Yii::t('app', 'От {from_days} до {to_days} дней', ['from_days' => $item->delivery_time_from, 'to_days' => $item->delivery_time_to])
                    : '',
                'comment' => nl2br($item->comment),
                'price' => (float) $item->cost,
                'price_currency' => Yii::$app->formatter->asCurrency(
                    (float) $item->cost,
                    $currency,
                    [\NumberFormatter::MAX_SIGNIFICANT_DIGITS => 100]
                ),
            ];
        }

        return $arr;
    }

    public function createOrder(
        $store_id,
        $order,
        $client,
        $lang_id,
        $success_url,
        $fail_url,
        $member_id = ''
    )
    {
        /**
         * payment_service
         * 1 Оплата через платежный шлюз
         * 2 Оплата кэшем в офисе
         * 3 Оплата через терминал
         * 4 Оплата по счету
         * 5 Оплата при получении
         **/

        $products = [];
        foreach ($order->products as $orderProduct) {
            $productSessia = $orderProduct->productSessia;
            $products[] = [
                'goods' => $productSessia->id,
                'quantity' => $orderProduct->quantity,
            ];
        }

        return $this->getResponse(
            'POST',
            '/market/' . $store_id . '/ordersAnonymous',
            array_filter([
                'payment_service' => 1,  // 0 - валидация
                'delivery_method' => $order->delivery_id,
                'delivery_address' => $order->delivery_type === 'delivery'
                    ? [
                        'country_name' => $client->country_id,
                        'country' => $client->country_id,
                        'city_name' => $client->city_id,
                        'city' => $client->city_id,
                        'post_code' => $client->post_code,
                        'street' => $client->street,
                        'home_number' => $client->home_number,
                        'room' => $client->room,
                        'full_name' => $client->name,
                        'phone' => $client->getPhone(),
                    ]
                    : [],
                'products' => $products,
                'name' => $client->name,
                'email' => $client->email,  // Если реферал, записываем его email https://jira.sessia.com/browse/WEBDEV-50
                'country_code' => $client->getCountryCode(),
                'phone' => $client->getPhone(),  // Если реферал, записываем его phone https://jira.sessia.com/browse/WEBDEV-50
                'lang_id' => $lang_id,
                'response_lang_id' => $lang_id,
                'success_url' => $success_url,
                'fail_url' => $fail_url,
                'campaign_id' => $_SERVER['SERVER_NAME'],
                'ext_discount' => YII_ENV_DEV ? '' : $order->price_discount, // https://jira.sessia.com/browse/ISSUE-8697
                'member_id' => $member_id, // Если галку не поставил, если поставил, то пусто
                'comment' => '', // Сюда если реферал передаём ФИО, email, phone
            ])
        );
    }

    public function getOrder($store_id, $order_id)
    {
        return $this->getResponseSimple(
            'GET',
            '/market/' . $store_id . '/orders/' . $order_id
        );
    }

    ####################################################################################################################

    public function getResponse(string $method, string $url, $params = '', bool $cache = false)
    {
        $url = self::SESSIA_URL . $url;
        $post = $method === 'POST';
        $params = json_encode($params, JSON_UNESCAPED_UNICODE);
        $time = 86400;

        $curl = new curl\Curl();

        if ($params) {
            if ($post) {
                $curl->setPostParams(Json::decode($params));
            } else {
                $curl->setGetParams(Json::decode($params));
            }
        }

        if ($cache) {
            $key = md5($url . $params);
            $response = Yii::$app->cache->getOrSet($key, function () use ($curl, $url, $post) {
                return $post ? $curl->post($url) : $curl->get($url);
            }, $time);
        } else {
            $response = $post ? $curl->post($url) : $curl->get($url);
        }

        return json_decode($response);
    }

    public function getResponseSimple(string $method, string $url)
    {
        $context = stream_context_create([
            'http' => [
                'method' => $method,
                'header' => 'Basic QXV0aG9yaXphdGlvbjpCZWFyZXIgTTJWbU56ZzRPRGt6TmpnME1tRTFNelpsWVRaaU56SmtOekkyTnpZMlptRTVNelU1TmpFM1ltSTFObUl5T1RkbE1XWXpNRFl4TXpnMFkyUTVNakkyWmc=',
            ],
        ]);

        $url = self::SESSIA_URL . $url;
        $responseHeaders = get_headers(
            $url,
            null,
            $context
        );
        if (in_array('HTTP/1.1 200 OK', $responseHeaders)) {
            return json_decode(file_get_contents(
                $url,
                false,
                $context
            ), false);
        }

        return false;
    }

    ####################################################################################################################














    public function getPopularGoods($store_id)
    {
        return $this->get('GET', self::SESSIA_URL . '/market/' . $store_id . '/popular-goods');
    }

    public function getCurrencies()
    {
        return $this->get('GET', self::SESSIA_URL . '/directory/currency/');
    }

    public function getDeliveryCountries(int $store_id)
    {
        return $this->get('GET', self::SESSIA_URL . '/market/delivery-countries/' . $store_id);
    }

    public function getCatalog(int $store_id)
    {
        return $this->get('GET', self::SESSIA_URL . '/market/' . $store_id . '/showcase-tree?' . http_build_query([
            'view' => 'plain',
            'depth' => 5,
            'lang_id' => 1,
        ]));
    }

    public function getProduct(int $product_id)
    {
        return $this->get('GET', self::SESSIA_URL . '/market/goods/' . $product_id . '?' . http_build_query([
            'lang_id' => 1,
        ]));
    }
}
