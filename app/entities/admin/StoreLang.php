<?php

namespace app\entities\admin;

use Yii;
use yii\db\ActiveRecord;

/**
 * @property int id
 * @property int store_id
 * @property int lang_id
 * @property string created_at
 * @property string updated_at
 */
class StoreLang extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%store_langs}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('admin', 'ID'),
            'store_id' => Yii::t('admin', 'Store ID'),
            'lang_id' => Yii::t('admin', 'Lang ID'),
            'created_at' => Yii::t('admin', 'Created date'),
            'updated_at' => Yii::t('admin', 'Updated date'),
        ];
    }
}
