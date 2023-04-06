<?php

namespace app\forms\admin;

use app\entities\admin\ProductImg;
use Yii;
use yii\base\Model;

/**
 * @property int id
 * @property int product_id
 * @property int currency_iso
 * @property string img
 * @property int position
 * @property string created_at
 * @property string updated_at
 */
class ProductImgForm extends Model
{
    public $id;
    public $product_id;
    public $currency_iso;
    public $img;
    public $position;
    public $created_at;
    public $updated_at;

    public function __construct(ProductImg $productImg = null, $config = [])
    {
        if ($productImg) {
            $this->product_id = $productImg->product_id;
            $this->currency_iso = $productImg->currency_iso;
        }
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'product_id' => Yii::t('admin', 'Product ID'),
            'currency_iso' => Yii::t('admin', 'Currency ISO'),
            'img' => Yii::t('admin', 'Изображение'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['product_id', 'currency_iso'], 'required'],
            [['img'], 'file', 'extensions' => ['jpg', 'png', 'gif', 'svg']],
        ];
    }
}
