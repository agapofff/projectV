<?php

namespace app\components;

use app\entities\user\User;
use Yii;
use yii\rbac\PhpManager;
use yii\rbac\Assignment;

class AuthManager extends PhpManager
{
    public function getAssignments($userId)
    {
        if ($userId && $user = $this->getUser($userId)) {
            $assignment = new Assignment();
            $assignment->userId = $user->getId();
            $assignment->roleName = $user->getRole();
            return [$assignment->roleName => $assignment];
        }
        return [];
    }

    public function getAssignment($roleName, $userId)
    {
        if ($userId && $user = $this->getUser($userId)) {
            if ($user->role === $roleName) {
                $assignment = new Assignment();
                $assignment->userId = $user->getId();
                $assignment->roleName = $user->getRole();
                return $assignment;
            }
        }
        return null;
    }

    public function assign($role, $userId)
    {
        if ($userId && $user = $this->getUser($userId)) {
            $this->setRole($user, $role->name);
        }
    }

    public function revoke($user, $roleName)
    {
        if ($user->id && $user = $this->getUser($user->id)) {
            if($user->role === $roleName) {
                $this->setRole($user, null);
            }
        }
    }

    public function revokeAll($userId)
    {
        if($userId && $user = $this->getUser($userId)) {
            $this->setRole($user, null);
        }
    }

    private function getUser($userId)
    {
        if (!Yii::$app->user->isGuest && Yii::$app->user->id === $userId) {
            return Yii::$app->user->identity;
        }
        return User::findOne($userId);
    }

    private function setRole($user, $roleName)
    {
        $user->role = $roleName;
        $user->updateAttributes(['role' => $roleName]);
    }
}