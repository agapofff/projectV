<?php

namespace app\forms\admin;

use app\entities\lang\Lang;
use Yii;
use yii\base\Model;

/**
 * @property int id
 * @property string url
 * @property string iso
 * @property string name
 * @property int active
 * @property string created_at
 * @property string updated_at
 */
class LangForm extends Model
{
    public $id;
    public $url;
    public $iso;
    public $name;
    public $active;
    public $created_at;
    public $updated_at;

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('admin', 'ID'),
            'url' => Yii::t('admin', 'Url'),
            'iso' => Yii::t('admin', 'ISO'),
            'name' => Yii::t('admin', 'Название'),
            'active' => Yii::t('admin', 'Включён'),
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
            [['id', 'url', 'iso', 'name'], 'required'],
            [['id', 'url', 'iso', 'name'], 'trim'],
            [['id', 'active'], 'integer'],
            [['id'], 'unique', 'targetClass' => Lang::class, 'filter' => ['<>', 'id', $this->id]],
            [['url'], 'string', 'min' => 2, 'max' => 2],
            [['iso'], 'string', 'min' => 5, 'max' => 10],
        ];
    }
}
