<?php

namespace app\components\rbac\rules;

use Yii;
use yii\rbac\Rule;

class GroupRule extends Rule
{
    public $name = 'group';

    public function execute($userId, $item, $params)
    {
        if (!Yii::$app->user->isGuest) {
            $role = Yii::$app->user->identity->getRole();
            if ($item->name === 'admin') {
                return $role === 'admin';
            } elseif ($item->name === 'translator') {
                return $role === 'admin' || $role === 'translator';
            } elseif ($item->name === 'seo') {
                return $role === 'admin' || $role === 'seo';
            } elseif ($item->name === 'post') {
                return $role === 'admin' || $role === 'post';
            }
        }
        return false;
    }
}
