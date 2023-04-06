<?php

namespace app\forms\admin;

use app\entities\admin\Product;
use Yii;
use yii\base\Model;

/**
 * @property int id
 * @property string sessia_vendor_code
 * @property string sessia_title
 * @property string sessia_img
 * @property string category
 * @property string collection
 * @property string sex
 * @property string problem
 * @property int position
 * @property int active
 * @property string created_at
 * @property string updated_at
 */
class ProductForm extends Model
{
    public $id;
    public $sessia_vendor_code;
    public $sessia_title;
    public $sessia_img;
    public $category;
    public $collection;
    public $sex;
    public $problem;
    public $position;
    public $active;
    public $created_at;
    public $updated_at;

    public function __construct(Product $product = null, $config = [])
    {
        if ($product) {
            $this->id = $product->id;
            $this->sessia_vendor_code = $product->sessia_vendor_code;
            $this->sessia_title = $product->sessia_title;
            $this->sessia_img = $product->sessia_img;
            $this->category = $product->category;
            $this->collection = $product->collection;
            $this->sex = explode(',', $product->sex);
            $this->problem = explode(',', $product->problem);
            $this->active = $product->active;
            $this->position = $product->position;
        }
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'category' => Yii::t('admin', 'Категория'),
            'collection' => Yii::t('admin', 'Коллекция'),
            'sex' => Yii::t('admin', 'Пол'),
            'problem' => Yii::t('admin', 'Проблемы'),
            'active' => Yii::t('admin', 'Включючен'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['sessia_vendor_code', 'category', 'collection', 'sex', 'problem', 'active'], 'safe'],
        ];
    }
}
