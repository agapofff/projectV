<?php

namespace app\forms\lang;

use app\entities\lang\Lang;
use Yii;
use yii\base\Model;

/**
 * @property int id
 * @property string url
 * @property string iso
 * @property string name
 * @property int store_id
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
    public $store_id;
    public $currency_iso;
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
            'store_id' => Yii::t('admin', 'Магазин'),
            'currency_iso' => Yii::t('admin', 'Валюта'),
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
            [['id', 'url', 'iso', 'name', 'store_id'], 'required'],
            [['id', 'url', 'iso', 'name', 'store_id'], 'trim'],
            [['id', 'store_id', 'active'], 'integer'],
            [['id'], 'unique', 'targetClass' => Lang::class, 'filter' => ['<>', 'id', $this->id]],
            [['url'], 'string', 'min' => 2, 'max' => 2],
            [['iso'], 'string', 'min' => 5, 'max' => 10],
            [['currency_iso'], 'safe'],
        ];
    }
}
