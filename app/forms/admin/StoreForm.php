<?php

namespace app\forms\admin;

use app\entities\admin\Store;
use Yii;
use yii\base\Model;

/**
 * @property int id
 * @property string type
 * @property string title
 * @property string currency_iso
 * @property int created_at
 * @property int updated_at
 */
class StoreForm extends Model
{
    public $id;
    public $type;
    public $title;
    public $currency_iso;
    public $created_at;
    public $updated_at;

    public function __construct(Store $store = null, $config = [])
    {
        if ($store) {
            $this->id = $store->id;
            $this->type = $store->type;
            $this->title = $store->title;
            $this->currency_iso = $store->currency_iso;
            $this->created_at = $store->created_at;
            $this->updated_at = $store->updated_at;
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
            'title' => Yii::t('admin', 'Название'),
            'currency_iso' => Yii::t('admin', 'Валюта ISO'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['id', 'type', 'title', 'currency_iso'], 'required'],
            [['title', 'currency_iso'], 'trim'],
            [['id'], 'integer'],
            [['id'], 'unique', 'targetClass' => Store::class, 'filter' => ['<>', 'id', $this->id]],
            [['currency_iso'], 'string', 'min' => 3, 'max' => 3],
        ];
    }
}
