<?php

namespace app\repositories;

use app\entities\user\User;

class UserRepository
{
    public function get($id)
    {
        return $this->getBy(['id' => $id]);
    }

    public function getByUsername($username)
    {
        return $this->getBy(['username' => $username]);
    }

    public function getByPasswordResetToken($token)
    {
        return $this->getBy(['password_reset_token' => $token]);
    }

    public function save(User $user)
    {
        if (!$user->save()) {
            throw new \RuntimeException('Saving error.');
        }
        return $user;
    }

    public function existsByPasswordResetToken(string $token): bool
    {
        return (bool) User::findByPasswordResetToken($token);
    }

    private function getBy(array $condition)
    {
        if (!$user = User::find()->andWhere($condition)->limit(1)->one()) {
            //throw new NotFoundException('User not found.');
        }
        return $user;
    }
}
