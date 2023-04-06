<?php

namespace app\entities\admin;

use Yii;
use yii\db\ActiveRecord;

/**
 * @property int id
 * @property int product_id
 * @property int currency_iso
 * @property string img
 * @property int position
 * @property string created_at
 * @property string updated_at
 */
class ProductImg extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%products_imgs}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('admin', 'ID'),
            'product_id' => Yii::t('admin', 'Product ID'),
            'currency_iso' => Yii::t('admin', 'Currency ISO'),
            'img' => Yii::t('admin', 'Img'),
            'position' => Yii::t('admin', 'Position'),
            'created_at' => Yii::t('admin', 'Created date'),
            'updated_at' => Yii::t('admin', 'Updated date'),
        ];
    }

    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    public static function create(
        $product_id,
        $img
    ): self
    {
        $model = new self();
        $model->product_id = $product_id;
        $model->img = $img;
        $model->position = time();

        return $model;
    }

    public function updateIso(
        $iso
    )
    {
        $this->currency_iso = $iso;
    }

    public function getDir()
    {
        return '/storage/store/product/' . $this->product_id . '/';
    }

    public function getUrl()
    {
        return $this->getDir() . $this->img . '?v=' . strtotime($this->updated_at);
    }

    public function getPrevName($img)
    {
        return str_replace('.', '-prev.', $img);
    }

    public function getUrlPrev()
    {
        return $this->getDir() . $this->getPrevName($this->img) . '?v=' . strtotime($this->updated_at);
    }
}
