<?php

namespace app\entities\about;

use Yii;
use yii\db\ActiveRecord;

/**
 * @property int id
 * @property string type
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
 * @property string updated_at
 */
class Post extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%posts}}';
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
            'created_at' => Yii::t('admin', 'Дата создания'),
            'updated_at' => Yii::t('admin', 'Дата обновления'),
        ];
    }

    ########################################################################

    public static function create($type, $lang): self
    {
        $model = new self();
        $model->type = $type;
        $model->lang = $lang;

        return $model;
    }

    public function edit(
        $type,
        $url,
        $cover,
        $img,
        $metadata_title,
        $metadata_description,
        $title,
        $announcement,
        $text,
        $created_at
    )
    {
        $this->type = $type;
        $this->url = $url;
        $this->cover = $cover;
        $this->img = $img;
        $this->metadata_title = $metadata_title;
        $this->metadata_description = $metadata_description;
        $this->title = $title;
        $this->announcement = $announcement;
        $this->text = $text;
        $this->created_at = $created_at;
    }

    ########################################################################

    public static function getTypeList()
    {
        return [
            'mass-media' => Yii::t('admin', 'Пресса'),
            'blog' => Yii::t('admin', 'Блог'),
        ];
    }

    public static function getTypeName($typeUrl)
    {
        foreach (self::getTypeList() as $key => $val) {
            if ($key === $typeUrl) {
                return $val;
                break;
            }
        }
        return 1;
    }

    ########################################################################

    public function getUrl()
    {
        if ($this->type === 'blog') {
            $url = 'blog';
        } else {
            $url = 'about';
        }
        return ['/' . $url . '/post/view', 'type' => $this->type, 'id' => $this->id, 'url' => $this->url];
    }

    public function getDir()
    {
        return '/storage/about/post/' . $this->id . '/';
    }

    public function getUrlCover()
    {
        return '@web' . $this->getDir() . $this->cover . '?v=' . strtotime($this->updated_at);
    }

    public function getUrlImg()
    {
        return '@web' . $this->getDir() . $this->img . '?v=' . strtotime($this->updated_at);
    }

    ########################################################################

    public function getPrev()
    {
        $model = self::find()
            ->where('lang = :lang AND url != "" AND type = :type AND created_at > :created_at', [
                'lang' => Yii::$app->language,
                'type' => $this->type,
                'created_at' => $this->created_at,
            ])
            ->orderBy('created_at ASC')
            ->one();

        return $model ? $model : false;
    }

    public function getNext()
    {
        $model = self::find()
            ->where('lang = :lang AND url != "" AND type = :type AND created_at < :created_at', [
                'lang' => Yii::$app->language,
                'type' => $this->type,
                'created_at' => $this->created_at,
            ])
            ->orderBy('created_at DESC')
            ->one();

        return $model ? $model : false;
    }

    ########################################################################

    public function getDate()
    {
        return Yii::$app->formatter->asDate($this->created_at, 'long');
    }

    public function getPrevText()
    {
        if (!empty($this->announcement)) {
            return $this->cutString(strip_tags($this->announcement), 255);
        }

        return $this->cutString(strip_tags($this->text), 255);
    }

    public function cutString($string, $length)
    {
        if ($length && mb_strlen($string) > $length) {
            $str = strip_tags($string);
            $str = mb_substr($str, 0, $length);
            $pos = mb_strrpos($str, ' ');
            return mb_substr($str, 0, $pos) . '…';
        }
        return $string;
    }
}
