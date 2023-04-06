<?php

namespace app\forms\user;

use Yii;
use yii\base\Model;
use app\entities\user\User;

class ProfileEditForm  extends Model
{
    public $username;
    public $password;
    public $newPassword;
    public $newPassword_repeat;

    public $user;

    public function __construct(User $user, $config = [])
    {
        $this->username = $user->username;
        $this->user = $user;
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['username', 'password'], 'required'],
            [['username'], 'email'],
            [['username'], 'string', 'max' => 255],
            [['username'], 'unique', 'targetClass' => User::class, 'filter' => ['<>', 'id', $this->user->id]],

            [['password'], 'checkCurrentPassword'],

            [['newPassword'], 'string', 'min' => 6],
            [['newPassword'], 'compare'],
            [['newPassword_repeat'], 'safe'],
        ];
    }

    /**
     * Чтобы поменять email, нужно ввести текущий пароль.
     * Чтобы изменить пароль нужно ввести текущий пароль.
     * Проверяем совпадает ли введённый пароль с текущим.
     */
    public function checkCurrentPassword()
    {
        if ($this->password != '') {
            if (!$this->user->validatePassword($this->password)) {
                $this->addError('password', Yii::t('admin', 'Текущий пароль не верен.'));
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('admin', 'E-mail'),
            'password' => Yii::t('admin', 'Пароль'),
            'newPassword' => Yii::t('admin', 'Новый пароль'),
            'newPassword_repeat' => Yii::t('admin', 'Повторите новый пароль'),
        ];
    }
}
