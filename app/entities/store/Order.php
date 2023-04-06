<?php

namespace app\entities\store;

use Yii;
use yii\db\ActiveRecord;

/**
 * @property int id
 *
 * @property int client_id
 *
 * @property string delivery_type
 * @property int delivery_id
 *
 * @property string promo_code
 *
 * @property int price_products
 * @property int price_discount
 * @property int price_delivery
 * @property int price_total
 * @property string currency
 *
 * @property string status
 *
 * @property string response
 *
 * @property string created_at
 * @property string updated_at
 */
class Order extends ActiveRecord
{

    public static function tableName(): string
    {
        return '{{%orders}}';
    }

    ####################################################################################################################

    public function getClient()
    {
        return $this->hasOne(Client::class, ['id' => 'client_id']);
    }

    public function getProducts()
    {
        return $this->hasMany(OrderProduct::class, ['order_id' => 'id']);
    }

    public function getPromoCode()
    {
        return $this->hasOne(PromoCode::class, ['code' => 'promo_code']);
    }

    ####################################################################################################################

    public static function create(
        int $client_id
    ): self
    {
        $model = new self();
        $model->client_id = $client_id;
        $model->currency = Yii::$app->params['currency'];
        $model->status = 'new';

        return $model;
    }

    public function editDelivery(
        $delivery_type,
        $delivery_id,
        $price_delivery
    ): void
    {
        $this->delivery_type = $delivery_type;
        $this->delivery_id = $delivery_id;
        $this->price_delivery = (int) $price_delivery;
    }

    public function editPromoCode(
        $promo_code
    ): void
    {
        $this->promo_code = $promo_code;
    }

    public function editPrices(
        $price_products,
        $price_discount,
        $price_total
    ): void
    {
        $this->price_products = (int) $price_products;
        $this->price_discount = (int) $price_discount;
        $this->price_total = (int) $price_total;
    }

    public function editResponse(
        $response
    ): void
    {
        $this->response = $response;
    }

    public function editStatus($status): void
    {
        $this->status = $status;
    }

    ####################################################################################################################

    public function getPriceProducts(): string
    {
        return $this->getPrice($this->price_products, $this->currency);
    }

    public function getPriceDiscount(): string
    {
        return $this->getPrice($this->price_discount, $this->currency);
    }

    public function getPriceDelivery(): string
    {
        return $this->getPrice($this->price_delivery, $this->currency);
    }

    public function getPriceTotal(): string
    {
        return $this->getPrice($this->price_total, $this->currency);
    }

    public function getPrice($value, $currency): string
    {
        return Yii::$app->formatter->asCurrency(
            $value,
            $currency,
            [\NumberFormatter::MAX_SIGNIFICANT_DIGITS => 100]
        );
    }

    public function getResponse()
    {
        return json_decode(htmlspecialchars_decode(str_replace("\r\n", "<br>", $this->response)));
    }

    public function getDeliveryTypes($pickup_list = [], $delivery_list = [])
    {
        return array_filter([
            !empty($pickup_list) ? (object) [
                'value' => 'pickup',
                'label' => Yii::t('app', 'Самовывоз'),
                'list' => $pickup_list,
            ] : '',
            !empty($delivery_list) ? (object) [
                'value' => 'delivery',
                'label' => Yii::t('app', 'Доставка'),
                'list' => $delivery_list,
            ] : '',
        ]);
    }

    public function getDeliveryTypeName()
    {
        foreach (self::getDeliveryTypes() as $val) {
            if ($val->value === $this->delivery_type) {
                return $val->label;
            }
        }

        return '';
    }

    public static function getPaymentStatus($payment_service_system, $payment_status)
    {
        if ($payment_service_system === 5) {
            $text_status = Yii::t('app', 'Оплата при получении');
        } else {
            switch ($payment_status) {
                case 100:
                    $text_status = Yii::t('app', 'Оплачен');
                    break;
                case 13:
                case 14:
                    $text_status = Yii::t('app', 'Возврат');
                    break;
                case 200:
                    $text_status = Yii::t('app', 'Отмена');
                    break;
                default:
                    $text_status = '';
            }
        }

        return $text_status;
    }
}
