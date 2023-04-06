<?php

namespace app\forms\contacts;

use Yii;
use yii\base\Model;

/**
 * @property string name
 * @property string email
 * @property string text
 */
class WriteForm extends Model
{
    public $name;
    public $email;
    public $text;

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'name' => Yii::t('app', 'Имя'),
            'email' => Yii::t('admin', 'Email'),
            'text' => Yii::t('app', 'Текст'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['name', 'email', 'text'], 'required'],
            [['name', 'email', 'text'], 'trim'],
            [['email'], 'email'],
        ];
    }
}
