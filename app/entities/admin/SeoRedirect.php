<?php

namespace app\entities\admin;

use Yii;
use yii\db\ActiveRecord;

/**
 * @property int id
 * @property string type
 * @property string url_from
 * @property string url_to
 * @property string created_at
 * @property string updated_at
 */
class SeoRedirect extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%seo_redirects}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('admin', 'ID'),
            'type' => Yii::t('admin', 'Тип'),
            'url_from' => Yii::t('admin', 'Ссылка с'),
            'url_to' => Yii::t('admin', 'Ссылка на'),
            'created_at' => Yii::t('admin', 'Created date'),
            'updated_at' => Yii::t('admin', 'Updated date'),
        ];
    }

    ####################################################################################################

    public static function create()
    {
        return new self();
    }

    public function edit(
        $type,
        $url_from,
        $url_to
    )
    {
        $this->type = $type;
        $this->url_from = $url_from;
        $this->url_to = $url_to;
    }
}
