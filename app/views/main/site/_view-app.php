<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

<section class="main-app">
    <div class="container">
        <div class="row">
            <div class="col-xl-4 col-lg-6">
                <h2 class="main-app__title fz2">
                    <?= Yii::t('app', 'Приложение {name}', ['name' => '<span>Project&nbsp;V</span>']) ?>
                </h2>
                <div class="main-app__text">
                    <?= Yii::t('app', 'Официальное приложение Project V — незаменимый помощник для партнеров и клиентов, которые хотят совершать покупки с максимальной выгодой и пользоваться всеми преимуществами программ привилегий нашего бренда и компании Freedom International Group') ?>
                </div>
                <div class="mobile">
                    <div class="row">
                        <?php for ($i = 1; $i <= 4; $i++) { ?>
                            <div class="col-xl-3 col-lg-6 col-3">
                                <div class="main-app__img" style="background-image: url('<?= Url::to('@web/storage/main/phone-' . $i . '.png?v=1') ?>')"></div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="main-app__caption">
                    <?= Yii::t('app', 'Скачайте приложение') ?>
                </div>
                <div class="main-app__btn-row">
                    <?= Html::a(null, 'https://apps.apple.com/app/project-v/id1220488838', ['target' => '_blank', 'rel' => 'nofollow', 'class' => 'main-app__btn store-apple']) ?>
                    <?= Html::a(null, 'https://play.google.com/store/apps/details?id=com.sessia', ['target' => '_blank', 'rel' => 'nofollow', 'class' => 'main-app__btn store-google']) ?>
                </div>
            </div>
            <div class="col-xl-8 col-lg-6">
                <div class="desktop tablet">
                    <div class="row">
                        <?php for ($i = 1; $i <= 4; $i++) { ?>
                            <div class="col-xl-3 col-lg-6 col-3">
                                <div class="main-app__img" style="background-image: url('<?= Url::to('@web/storage/main/phone-' . $i . '.png?v=1') ?>')"></div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
