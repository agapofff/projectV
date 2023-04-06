<?php

namespace app\entities\admin;

use Yii;
use yii\db\ActiveRecord;

/**
 * @property int id
 * @property int store_id
 * @property int product_id
 * @property int price_value
 * @property string price_iso
 * @property int position
 * @property int active
 * @property string created_at
 * @property string updated_at
 */
class ProductSessia extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%products_sessia}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('admin', 'ID'),
            'store_id' => Yii::t('admin', 'Store ID'),
            'product_id' => Yii::t('admin', 'Product ID'),
            'active' => Yii::t('admin', 'Active'),
            'created_at' => Yii::t('admin', 'Created date'),
            'updated_at' => Yii::t('admin', 'Updated date'),
        ];
    }

    ####################################################################################################################

    public function getStore()
    {
        return $this->hasOne(Store::class, ['id' => 'store_id']);
    }

    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    public static function getParent($store_id, $product_id)
    {
        return self::find()
            ->where('store_id = :store_id AND product_id = :product_id', [
                'store_id' => $store_id,
                'product_id' => $product_id,
            ])
            ->one();
    }

    public static function getSessiaForCart(int $product_id)
    {
        return ProductSessia::find()->alias('ps')
            //->innerJoin('tbl_stores s', 's.id = ps.store_id')
            ->where([
                'ps.product_id' => $product_id,
                'ps.store_id' => Yii::$app->params['store_id'],
            ])
            ->orderBy('ps.store_id')
            ->one();
    }

    ####################################################################################################################

    public static function create(
        $id,
        $store_id,
        $product_id,
        $price_value,
        $price_iso,
        $position
    ): self
    {
        $model = new self();
        $model->id = $id;
        $model->store_id = $store_id;
        $model->product_id = $product_id;
        $model->price_value = $price_value;
        $model->price_iso = $price_iso;
        $model->position = $position;
        $model->active = 1;

        return $model;
    }

    ####################################################################################################################

    public function getEmptyPriceFormatter()
    {
        $model = new self();
        $model->active = 1;
        $model->price_iso = Yii::$app->params['currency'];
        return $model->getPriceFormatter(1, 0);
    }

    public function getPriceInteger($quantity = 1, $price_value = null)
    {
        $price_value = $price_value === null ? $this->price_value : $price_value;
        return $price_value * $quantity;
    }

    public function getPriceFormatter($quantity = 1, $price_value = null)
    {
        $price_value = $this->getPriceInteger($quantity, $price_value);
        $price_iso = str_replace(0, '', $this->setPriceFormatter(0));

        return '<div class="price">'. str_replace(
                '0',
                '<div class="price__value">' . str_replace($price_iso, '', $this->setPriceFormatter($price_value)) . '</div><div class="price__currency">',
                $this->setPriceFormatter(0)
            ) . '</div></div>';
    }

    public function getDeliveryPrice()
    {
        return 0;
    }

    public function getDeliveryPriceFormatter()
    {
        $html = '<div class="price">';
        $html .= str_replace(
            '0',
            '<div class="price__value">0</div><div class="price__currency">',
            $this->setPriceFormatter(0)
        ) . '</div>';
        $html .= '</div>';

        return $html;
    }

    public function setPriceFormatter($price_value)
    {
        return Yii::$app->formatter->asCurrency(
            $price_value,
            $this->price_iso,
            [\NumberFormatter::MAX_SIGNIFICANT_DIGITS => 100]
        );
    }
}
