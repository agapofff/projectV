<?php

namespace app\forms\admin;

use app\entities\admin\ProductTranslate;
use Yii;
use yii\base\Model;

/**
 * @property int id
 * @property int product_id
 * @property int lang_id
 * @property string title
 * @property string description
 * @property string properties
 * @property string benefits
 * @property string video
 * @property string main_components
 * @property string composition
 * @property string recommendations
 * @property string dosage
 * @property string storage
 * @property string issue
 * @property string created_at
 * @property string updated_at
 */
class ProductTranslateForm extends Model
{
    public $id;
    public $title;
    public $description;
    public $properties;
    public $benefits;
    public $video;
    public $main_components;
    public $composition;
    public $recommendations;
    public $dosage;
    public $storage;
    public $issue;
    public $created_at;
    public $updated_at;

    public function __construct(ProductTranslate $productTranslate = null, $config = [])
    {
        if ($productTranslate) {
            $this->id = $productTranslate->id;
            $this->title = $productTranslate->title;
            $this->description = $productTranslate->description;
            $this->properties = $productTranslate->properties;
            $this->benefits = $productTranslate->benefits;
            $this->video = $productTranslate->video;
            $this->main_components = $productTranslate->main_components;
            $this->composition = $productTranslate->composition;
            $this->recommendations = $productTranslate->recommendations;
            $this->dosage = $productTranslate->dosage;
            $this->storage = $productTranslate->storage;
            $this->issue = $productTranslate->issue;
        }
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'title' => Yii::t('admin', 'Заголовок'),
            'description' => Yii::t('admin', 'Описание'),
            'properties' => Yii::t('admin', 'Свойства'),
            'benefits' => Yii::t('admin', 'Преимущества'),
            'video' => Yii::t('admin', 'Видео'),
            'main_components' => Yii::t('admin', 'Основные компоненты'),
            'composition' => Yii::t('admin', 'Состав'),
            'recommendations' => Yii::t('admin', 'Рекомендации'),
            'dosage' => Yii::t('admin', 'Дозировка'),
            'storage' => Yii::t('admin', 'Хранение'),
            'issue' => Yii::t('admin', 'Форма выпуска'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['title', 'description', 'properties', 'benefits', 'video','main_components',
                'composition', 'recommendations', 'dosage', 'storage', 'issue'], 'safe'],
            [['title', 'description', 'properties', 'benefits', 'video', 'main_components',
                'composition', 'recommendations', 'dosage', 'storage', 'issue'], 'trim'],
        ];
    }
}
