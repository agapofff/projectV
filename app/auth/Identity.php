<?php

namespace app\auth;

use Yii;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;
use app\entities\user\User;
use app\repositories\UserRepository;

class Identity implements IdentityInterface
{
    private $user;
    public $login = 'admin';
    public $role;

    /**
     * Identity constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        $user = self::getRepository()->get($id);
        return $user ? new self($user): null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('findIdentityByAccessToken is not implemented.');
    }

    /**
     * @inheritdoc
     */
    public function getId(): int
    {
        return $this->user->id;
    }

    /**
     * @inheritdoc
     */
    public function getLogin(): int
    {
        return $this->user->login;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey(): string
    {
        return $this->user->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function getRole(): string
    {
        return $this->user->role;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    private static function getRepository()
    {
        return Yii::$container->get(UserRepository::class);
    }
}