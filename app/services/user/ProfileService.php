<?php

namespace app\services\user;

use Yii;
use app\forms\user\ProfileEditForm;
use app\repositories\UserRepository;

class ProfileService
{
    private $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function edit($id, ProfileEditForm $form): void
    {
        $user = $this->users->get($id);
        if ($form->newPassword === '') {
            $user->editUsername($form->username);
            //Mail::send('EditUsername', $user);
        } else {
            $user->editPassword($form->username, $form->newPassword);
            //Mail::send('EditPassword', $user, ['password'=>$form->newPassword]);
        }
        $this->users->save($user);
    }
}
