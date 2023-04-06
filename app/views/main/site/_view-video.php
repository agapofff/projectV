<?php

use yii\helpers\Url;

switch (Yii::$app->language) {
    case 'ru-RU':
        $lang = 'ru';
        break;
    case 'vi-VN':
        $lang = 'vi';
        break;
    default:
        $lang = 'en';
}

?>

<section class="main-video">
    <div class="main-video__content video">
        <div class="video__muted"></div>
        <video class="video__iframe" autoplay loop muted playsinline>
            <source src="<?= Url::to('@web/storage/main/item-' . $category . '-' . $lang . '.mp4?v=1') ?>" type="video/mp4">
        </video>
    </div>
    <div class="main-video__info">
        <div class="container">
            <div class="main-video__networks">
                <?= $this->renderFile('@app/views/layouts/_networks.php') ?>
            </div>
        </div>
    </div>
</section>
