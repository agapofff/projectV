<?php

namespace app\services\auth;

use app\entities\user\User;
use app\forms\auth\LoginForm;
use app\repositories\UserRepository;

class AuthService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function auth(LoginForm $form): User
    {
        $user = $this->userRepository->getByUsername($form->username);
        if (!$user || !$user->validatePassword($form->password, $form->username)) {
            throw new \DomainException('Undefined user or password.');
        }
        return $user;
    }
}
