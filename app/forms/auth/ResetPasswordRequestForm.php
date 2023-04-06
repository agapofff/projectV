<?php

namespace app\forms\auth;

use Yii;
use yii\base\Model;
use app\entities\user\User;

class ResetPasswordRequestForm extends Model
{
    public $username;

    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'email'],
            ['username', 'exist',
                'targetClass' => User::class,
                'message' => 'There is no user with this email address.'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('admin', 'E-mail'),
        ];
    }
}
