<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use app\components\rbac\rules\AuthorRule;
use app\components\rbac\rules\GroupRule;

/**
 * RBAC console controller.
 */
class RbacController extends Controller
{
    public function actionInit($id = null)
    {
        $auth = Yii::$app->authManager;

        // Rules
        $authorRule = new AuthorRule();
        $auth->add($authorRule);

        $groupRule = new GroupRule();
        $auth->add($groupRule);

        // Roles
        $post = $auth->createRole('post');
        $post->description = 'Post';
        $post->ruleName = $groupRule->name;
        $auth->add($post);

        $seo = $auth->createRole('seo');
        $seo->description = 'SEO';
        $seo->ruleName = $groupRule->name;
        $auth->add($seo);

        $translator = $auth->createRole('translator');
        $translator->description = 'Translator';
        $translator->ruleName = $groupRule->name;
        $auth->add($translator);

        $admin = $auth->createRole('admin');
        $admin->description = 'Admin';
        $admin->ruleName = $groupRule->name;
        $auth->add($admin);
        $auth->addChild($admin, $seo);
        $auth->addChild($admin, $translator);

        // Admin assignments
        if ($id !== null) {
            $auth->assign($admin, $id);
        }
    }
}