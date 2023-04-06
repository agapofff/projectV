<?php

namespace app\components\rbac\rules;

use yii\rbac\Rule;

class AuthorRule extends Rule
{
    public $name = 'autor';

    public function execute($userId, $item, $params)
    {
        return isset($params['post']) ? $params['post']->user_id == $userId : false;
    }
}