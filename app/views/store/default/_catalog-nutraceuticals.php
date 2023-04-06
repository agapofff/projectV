<?php

use yii\helpers\Url;

?>

<?php if ($problemArr) { ?>
<div class="problem">
<?php foreach ($problemArr as $val) { ?>
    <div class="problem__row row">
        <div class="problem__left col-lg-8">
            <div class="problem__content problem__content_left">
                <div class="problem__title">
                    <?= $val->title ?>
                </div>
                <?php foreach ($val->text as $text) { ?>
                    <?php if (preg_match("(text|product)", $text->type)) { ?>
                        <div class="problem__text">
                            <?= $text->content ?>
                        </div>
                    <?php } elseif ($text->type === 'list') { ?>
                        <ul class="problem__list">
                            <?php foreach ($text->content as $content) { ?>
                                <li class="problem__item">
                                    <span class="problem__item-icon"></span>
                                    <?= $content[0] ?>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>

        <div class="problem__right col-lg-4">
            <?php if ($val->type === 'main') { ?>
                <div class="problem__content">
                    <div class="problem__img problem__img_arrow" style="background-image: url('<?= Url::to($problemModel->getImg('arrow.svg?v=1')) ?>')"></div>
                </div>
            <?php } elseif ($val->type === 'default') { ?>
                <div class="problem__content">
                    <div class="problem__img" style="background-image: url('<?= Url::to($problemModel->getImg($val->img)) ?>')"></div>
                </div>
            <?php } elseif ($val->type === 'product') { ?>
                <?php $product = $problemModel->getProduct($val->img); ?>
                <?php $productCover = $product->coverByCurrencyIso; ?>
                <?php if ($product && $productCover) { ?>
                    <div class="problem__content problem__content_bg">
                        <div class="problem__product" style="background-image: url('<?= Url::to('@web' . $productCover->getUrl()) ?>')"></div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
<?php } ?>
</div>
<?php } ?>

<div class="dietary-supplement">
    <div class="dietary-supplement__title fz5">
        <?= Yii::t('app', 'БАД. Не является лекарственным средством.') ?>
    </div>
</div>
