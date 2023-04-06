<?php

use yii\helpers\Url;

?>

<?php if ($model->component4) { ?>
<div class="component component-4">
    <?php if ($model->component4->bg) { ?>
    <div class="component-4__bg" data-aos="fade-in" style="background-image: url(<?= Url::to($url . '4-bg.jpg?v=1') ?>);"></div>
    <?php } ?>
    <div class="container">
        <?php if (!empty($model->component4->title)) { ?>
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <h2 class="component-4__title fz3" data-aos="slide-up">
                    <?= $model->component4->title ?>
                </h2>
            </div>
        </div>
        <?php } ?>
        <?php if (!empty($model->component4->text)) { ?>
        <div class="row">
            <div class="col-lg-4 offset-lg-4">
                <div class="component-4__text fz5" data-aos="slide-up" <?= $model->component4->img ? '' : 'style="margin:0;"' ?>>
                    <?= $model->component4->text ?>
                </div>
            </div>
        </div>
        <?php } ?>
        <?php if ($model->component4->img) { ?>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="component-4__img" data-aos="fade" style="background-image: url(<?= Url::to($url . '4-img.jpg?v=1') ?>);"></div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
<?php } ?>

<?php if ($model->component5) { ?>
<div class="component component-5">
    <div class="container">
        <?php if (!empty($model->component5->title)) { ?>
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <h2 class="component-5__title fz2" data-aos="slide-up">
                    <?= $model->component5->title ?>
                </h2>
            </div>
        </div>
        <?php } ?>
        <?php if (!empty($model->component5->text)) { ?>
        <div class="row">
            <div class="col-lg-4 offset-lg-4">
                <div class="component-5__text fz5" data-aos="slide-up">
                    <?= $model->component5->text ?>
                </div>
            </div>
        </div>
        <?php } ?>
        <?php if ($model->component5->img) { ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="component-5__img" data-aos="fade" style="background-image: url(<?= Url::to($url . '5-img.jpg?v=1') ?>);"></div>
            </div>
        </div>
        <?php } ?>
        <?php if (!empty($model->component5->caption1) && !empty($model->component5->caption2)) { ?>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="component-5__text-2 component-5__text-2_first fz5" data-aos="slide-up">
                            <?= $model->component5->caption1 ?>
                        </div>
                    </div>
                    <div class="col-lg-5 offset-lg-2">
                        <div class="component-5__text-2 fz5" data-aos="slide-up">
                            <?= $model->component5->caption2 ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
    <?php if ($model->component5->bg) { ?>
    <div class="component-5__bg" data-aos="fade" style="background-image: url(<?= Url::to($url . '5-bg.jpg?v=1') ?>);"></div>
    <?php } ?>
</div>
<?php } ?>

<?php if ($model->component6) { ?>
<div class="component component-6">
    <div class="container">
        <?php if (!empty($model->component6->text1)) { ?>
        <div class="component-6__row-1 row">
            <div class="col-lg-5">
                <div class="component-6__content">
                    <?php if (!empty($model->component6->title1)) { ?>
                    <div class="component-6__title fz2" data-aos="slide-up">
                        <?= $model->component6->title1 ?>
                    </div>
                    <?php } ?>
                    <div class="component-6__img-1 mobile" data-aos="fade" style="background-image: url(<?= Url::to($url . '6-img-1.jpg?v=1') ?>);"></div>
                    <div class="component-6__text-1 fz5" data-aos="slide-up">
                        <?= $model->component6->text1 ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 offset-lg-1">
                <div class="component-6__img-1 desktop tablet" data-aos="fade" style="background-image: url(<?= Url::to($url . '6-img-1.jpg?v=1') ?>);"></div>
            </div>
        </div>
        <?php } ?>
        <?php if (!empty($model->component6->text2)) { ?>
        <div class="component-6__row-2 row">
            <div class="col-lg-5">
                <div class="component-6__img-2" data-aos="fade" style="background-image: url(<?= Url::to($url . '6-img-2.jpg?v=1') ?>);"></div>
            </div>
            <div class="col-lg-4 offset-lg-1">
                <div class="component-6__content">
                    <?php if (!empty($model->component6->title2)) { ?>
                    <div class="component-6__title fz2" data-aos="slide-up">
                        <?= $model->component6->title2 ?>
                    </div>
                    <?php } ?>
                    <div class="component-6__text-2 fz5" data-aos="slide-up">
                        <?= $model->component6->text2 ?>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
<?php } ?>
