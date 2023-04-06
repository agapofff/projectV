<?php

namespace app\forms\contacts;

use Yii;
use yii\base\Model;

/**
 * @property string name
 * @property string phone
 */
class CallForm extends Model
{
    public $name;
    public $phone;

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'name' => Yii::t('app', 'Имя'),
            'phone' => Yii::t('app', 'Телефон'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['name', 'phone'], 'required'],
            [['name', 'phone'], 'trim'],
        ];
    }
}
