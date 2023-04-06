<?php

namespace app\services\auth;

use Yii;
use app\forms\auth\ResetPasswordForm;
use app\forms\auth\ResetPasswordRequestForm;
use app\repositories\UserRepository;

class PasswordResetService
{
    private $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function request(ResetPasswordRequestForm $form): void
    {
        $user = $this->users->getByUsername($form->username);

        $user->requestPasswordReset();
        $this->users->save($user);

        $sent = Yii::$app->mailer
            ->compose(
                ['html' => 'auth/reset/confirm-html', 'text' => 'auth/reset/confirm-text'],
                ['user' => $user]
            )
            ->setTo($user->username)
            ->setSubject('Password reset for ' . Yii::$app->name)
            ->send();

        if (!$sent) {
            throw new \RuntimeException('Sending error.');
        }
    }

    public function validateToken($token): void
    {
        if (empty($token) || !is_string($token)) {
            throw new \DomainException('Password reset token cannot be blank.');
        }
        if (!$this->users->existsByPasswordResetToken($token)) {
            throw new \DomainException('Wrong password reset token.');
        }
    }

    public function reset(string $token, ResetPasswordForm $form): void
    {
        $user = $this->users->getByPasswordResetToken($token);
        $user->resetPassword($form->password);
        $this->users->save($user);
    }

    public function resetAdmin(int $id, ResetPasswordForm $form): void
    {
        $user = $this->users->get($id);

        $user->requestPasswordReset();
        $this->users->save($user);

        $user->resetPassword($form->password);
        $this->users->save($user);
    }
}
