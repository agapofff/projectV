<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $user \app\entities\user\User */

$resetLink = Url::to(['auth/reset/confirm', 'token' => $user->password_reset_token], true);
?>
Hello <?= $user->username ?>,

Follow the link below to reset your password:

<?= $resetLink ?>
