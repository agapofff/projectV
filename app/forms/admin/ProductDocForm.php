<?php

namespace app\forms\admin;

use Yii;
use yii\base\Model;

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
class ProductDocForm extends Model
{
    public $id;
    public $product_id;
    public $lang_id;
    public $doc;
    public $title;
    public $position;
    public $created_at;
    public $updated_at;

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
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

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['product_id', 'lang_id'], 'required'],
            [['doc'], 'file', 'extensions' => ['jpg', 'png', 'gif', 'svg', 'doc', 'docx', 'pdf']],
        ];
    }
}
