<?php

namespace app\forms\admin;

use app\entities\admin\SeoMetadata;
use Yii;
use yii\base\Model;

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
class SeoMetadataForm extends Model
{
    public $id;
    public $link;
    public $title;
    public $description;
    public $h1;
    public $text;
    public $created_at;
    public $updated_at;

    public function __construct(SeoMetadata $seoMetadata = null, $config = [])
    {
        if ($seoMetadata) {
            $this->link = $seoMetadata->link;
            $this->title = $seoMetadata->title;
            $this->description = $seoMetadata->description;
            $this->h1 = $seoMetadata->h1;
            $this->text = $seoMetadata->text;
        }
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('admin', 'ID'),
            'link' => Yii::t('admin', 'Линк'),
            'title' => Yii::t('admin', 'title'),
            'description' => Yii::t('admin', 'description'),
            'h1' => Yii::t('admin', 'h1'),
            'text' => Yii::t('admin', 'Текст'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['link', 'title', 'description', 'h1', 'text'], 'trim'],
            [['link', 'title', 'description', 'h1', 'text'], 'safe'],
        ];
    }
}
