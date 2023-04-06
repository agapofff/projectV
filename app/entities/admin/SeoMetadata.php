<?php

namespace app\entities\admin;

use Yii;
use yii\db\ActiveRecord;

/**
 * @property int id
 * @property string link
 * @property string title
 * @property string description
 * @property string h1
 * @property string text
 * @property string created_at
 * @property string updated_at
 */
class SeoMetadata extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%seo_metadatas}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('admin', 'ID'),
            'link' => Yii::t('admin', 'Линк'),
            'title' => Yii::t('admin', 'title'),
            'description' => Yii::t('admin', 'description'),
            'h1' => Yii::t('admin', 'h1'),
            'text' => Yii::t('admin', 'Текст'),
            'created_at' => Yii::t('admin', 'Created date'),
            'updated_at' => Yii::t('admin', 'Updated date'),
        ];
    }

    ####################################################################################################

    public static function create()
    {
        return new self();
    }

    public static function currentPage(
        $title,
        $description,
        $h1,
        $text
    )
    {
        $model = new self();
        $model->title = $title;
        $model->description = $description;
        $model->h1 = $h1;
        $model->text = $text;

        return $model;
    }

    public function edit(
        $link,
        $title,
        $description,
        $h1,
        $text
    )
    {
        $this->link = $link;
        $this->title = $title;
        $this->description = $description;
        $this->h1 = $h1;
        $this->text = $text;
    }
}
