<?php

namespace app\entities\admin;

use Yii;
use yii\db\ActiveRecord;

/**
 * @property int id
 * @property int product_id
 * @property int lang_id
 * @property string doc
 * @property string title
 * @property int position
 * @property string created_at
 * @property string updated_at
 */
class ProductDoc extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%products_docs}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('admin', 'ID'),
            'product_id' => Yii::t('admin', 'Product ID'),
            'lang_id' => Yii::t('admin', 'Lang ID'),
            'doc' => Yii::t('admin', 'Документ'),
            'title' => Yii::t('admin', 'Заголовок'),
            'position' => Yii::t('admin', 'Позиция'),
            'created_at' => Yii::t('admin', 'Created date'),
            'updated_at' => Yii::t('admin', 'Updated date'),
        ];
    }

    public static function create(
        $product_id,
        $lang_id,
        $doc,
        $title
    ): self
    {
        $model = new self();
        $model->product_id = $product_id;
        $model->lang_id = $lang_id;
        $model->doc = $doc;
        $model->title = $title;
        $model->position = time();

        return $model;
    }

    public function changeTitle($title)
    {
        $this->title = $title;
    }

    public function getDir()
    {
        return '/storage/store/product/' . $this->product_id . '/';
    }

    public function getUrl()
    {
        return $this->getDir() . $this->doc . '?v=' . strtotime($this->updated_at);
    }
}
