<?php

namespace app\entities\store;

use app\entities\admin\Product;
use app\entities\admin\ProductSessia;
use Yii;
use yii\db\ActiveRecord;

/**
 * @property int id
 * @property string hash
 * @property int order_id
 * @property int product_id
 * @property int quantity
 * @property int price
 * @property string currency_iso
 * @property string created_at
 * @property string updated_at
 */
class OrderProduct extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%order_products}}';
    }

    ####################################################################################################################

    public function getOrder()
    {
        return $this->hasOne(Order::class, ['id' => 'order_id']);
    }

    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    public function getProductSessia()
    {
        return $this->hasOne(ProductSessia::class, ['product_id' => 'product_id'])
            ->where(['store_id' => Yii::$app->params['store_id']]);
    }

    ####################################################################################################################

    public static function create(
        $order_id,
        $product_id,
        $quantity,
        $price,
        $currency_iso
    ): self
    {
        $model = new self();
        $model->order_id = $order_id;
        $model->product_id = $product_id;
        $model->quantity = $quantity;
        $model->price = $price;
        $model->currency_iso = $currency_iso;

        return $model;
    }

    public function editQuantity($quantity): void
    {
        if ($quantity >= 1 && $quantity <= 99) {
            $this->quantity = $quantity;
        }
    }

    public function getPrice(): string
    {
        return Yii::$app->formatter->asCurrency(
            $this->price,
            $this->currency_iso,
            [\NumberFormatter::MAX_SIGNIFICANT_DIGITS => 100]
        );
    }
}
