<?php

namespace app\forms\about;

use app\entities\about\Post;
use Yii;
use yii\base\Model;

/**
 * @property int id
 * @property int type
 * @property string lang
 * @property string url
 * @property string cover
 * @property string img
 * @property string metadata_title
 * @property string metadata_description
 * @property string title
 * @property string announcement
 * @property string text
 * @property string created_at
 */
class PostForm extends Model
{
    public $id;
    public $type;
    public $lang;
    public $url;
    public $cover;
    public $img;
    public $metadata_title;
    public $metadata_description;
    public $title;
    public $announcement;
    public $text;
    public $created_at;

    public function __construct(Post $model = null, $config = [])
    {
        if ($model) {
            $this->id = $model->id;
            $this->type = $model->type;
            $this->lang = $model->lang;
            $this->url = $model->url;
            $this->cover = $model->cover;
            $this->img = $model->img;
            $this->metadata_title = $model->metadata_title;
            $this->metadata_description = $model->metadata_description;
            $this->title = $model->title;
            $this->announcement = $model->announcement;
            $this->text = $model->text;
            $this->created_at = substr(str_replace(' ', 'T', $model->created_at), 0, -3);
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
            'type' => Yii::t('admin', 'Тип'),
            'lang' => Yii::t('admin', 'Язык'),
            'url' => Yii::t('admin', 'Алиас'),
            'cover' => Yii::t('admin', 'Обложка'),
            'img' => Yii::t('admin', 'Изображение'),
            'metadata_title' => Yii::t('admin', 'Metadata: Title'),
            'metadata_description' => Yii::t('admin', 'Metadata: Description'),
            'title' => Yii::t('admin', 'Заголовок'),
            'announcement' => Yii::t('admin', 'Анонс'),
            'text' => Yii::t('admin', 'Текст'),
            'created_at' => Yii::t('admin', 'Дата публикации'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['cover', 'img', 'metadata_title', 'metadata_description', 'title', 'announcement', 'text'], 'trim'],
            [['type', 'title'], 'required'],
            [['cover', 'img'], 'file', 'extensions' => ['jpg', 'png', 'gif', 'svg']],
            [['cover', 'img', 'metadata_title', 'metadata_description', 'announcement', 'text', 'created_at'], 'safe'],
        ];
    }
}
