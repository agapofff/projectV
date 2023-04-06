<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAssetAdmin;

AppAssetAdmin::register($this);

?>

<?php $this->beginContent('@app/views/layouts/main.php') ?>

<?= $content ?>

<?php $this->endContent() ?>
