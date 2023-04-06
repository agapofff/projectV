<?php

use yii\helpers\Url;

?>

<div class="component component-1">
    <div class="container">
        <div class="component-1__content" data-aos="fade" style="background-image: url(<?= Url::to($url . '1-bg-header.jpg?v=1') ?>);">
            <div class="row">
                <div class="col-lg-11 offset-lg-1">
                    <h1 class="component-1__title fz2" data-aos="slide-up">
                        <?= $model->component1->title ?>
                    </h1>
                </div>
                <div class="col-lg-4 offset-lg-1">
                    <div class="component-1__text" data-aos="slide-up">
                        <?= $model->component1->text ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="component component-2">
    <div class="row">
        <div class="col-lg-4">
            <div class="component-2__bg" data-aos="fade" style="background-image: url(<?= Url::to($url . '2-bg-1.jpg?v=1') ?>);"></div>
        </div>
        <div class="col-lg-4">
            <div class="component-2__text" data-aos="slide-up" data-aos-easing="ease" data-aos-delay="800">
                <?php if (!empty($model->component2->title)) { ?>
                    <span class="component-2__title fz4">
                        <?= $model->component2->title ?>
                    </span>
                    <br><br>
                <?php } ?>
                <?= $model->component2->text ?>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="component-2__bg" data-aos="fade" style="background-image: url(<?= Url::to($url . '2-bg-2.jpg?v=1') ?>);"></div>
        </div>
    </div>
</div>

<div class="component component-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <h2 class="component-3__title fz2" data-aos="slide-up">
                    <?= $model->component3->title ?>
                </h2>
                <div class="row">
                    <div class="col-lg-10">
                        <div class="component-3__text fz5" data-aos="slide-up">
                            <?= $model->component3->text ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="row h100">
                    <div class="col-lg-8">
                        <div class="component-3__img-1" data-aos="fade" style="background-image: url(<?= Url::to($url . '3-img-1.jpg?v=1') ?>);"></div>
                    </div>
                    <div class="col-lg-4">
                        <div class="component-3__img-2" data-aos="fade" style="background-image: url(<?= Url::to($url . '3-img-2.jpg?v=1') ?>);"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
