<?php

namespace app\entities\contacts;

use Yii;
use yii\helpers\Html;

/**
 * @property string payment_title
 * @property string payment_text
 * @property array payment_params
 * @property string delivery_title
 * @property string delivery_text
 * @property string delivery_info
 * @property array delivery_params
 */
class Delivery
{
    public $payment_title;
    public $payment_text;
    public $payment_params;
    public $delivery_title;
    public $delivery_text;
    public $delivery_info;
    public $delivery_params;

    public function __construct()
    {
        $data = $this->getData();

        $this->payment_title = $data['payment_title'];
        $this->payment_text = $data['payment_text'];
        $this->payment_params = $data['payment_params'];
        $this->delivery_title = $data['delivery_title'];
        $this->delivery_text = $data['delivery_text'];
        $this->delivery_info = $data['delivery_info'];
        $this->delivery_params = $data['delivery_params'];
    }

    ####################################################################################################################

    public static function getData()
    {
        if (Yii::$app->params['currency'] === 'RUB') {
            $delivery_text = Yii::t('admin', 'Курьерская служба СДЭК — в России {br}и странах ТС.', ['br' => '<br>']);
        } elseif (Yii::$app->params['currency'] === 'VND') {
            $delivery_text = Yii::t('admin', 'Viettel Post');
        } else {
            $delivery_text = Yii::t('app', 'DHL и Austrian Post — {br}в Европе, США, Канаде, Австралии, Азии.', ['br' => '<br>']);
        }

        return [
            'payment_title' => Yii::t('app', 'Способы оплаты', ['br' => '<br>']),
            'payment_text' => Yii::t('app', 'Заказы можно оплатить через ProjectV {br}с помощью банковских карт и кэшбэков, {br}а также наличными и картой в офисах.', [
                'br' => '<br>',
            ]),
            'payment_params' => Yii::$app->params['currency'] === 'RUB'
                ? ['visa', 'mir', 'mastercard', 'projectv']
                : ['visa', 'mastercard', 'projectv', 'paypal'],
            'delivery_title' => Yii::t('app', 'Способы доставки', ['br' => '<br>']),
            'delivery_text' => $delivery_text,
            'delivery_info' => Yii::t('app', 'Стоимость доставки зависит от страны и удаленности населенного пункта от нашего логистического центра, веса и объема посылки.'),
            'delivery_params' => Yii::$app->params['currency'] === 'RUB'
                ? [
                    Yii::t('app', 'Россия') => '~ 300₽',
                ]
                : [
                    Yii::t('app', 'Европа') => '~ 10€',
                ],
        ];
    }
}
