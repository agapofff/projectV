<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

?>

<section class="c-header c-header_<?= $id ?>">
    <div class="container">
        <div class="c-header__bg" style="background-image: url(<?= Url::to($url . 'header.jpg?v=1') ?>);">
            <div class="c-header__content">
                <div class="row">
                    <div class="col-xl-5 offset-xl-1 col-lg-7 offset-lg-1">
                        <h1 class="c-header__title c-fz1">
                            <?= $model->header->title ?>
                        </h1>
                    </div>
                </div>
                <?php if ($model->header->text) { ?>
                <div class="row">
                    <div class="col-xl-4 offset-xl-1 col-lg-6 offset-lg-1">
                        <div class="c-header__text c-fz4">
                            <?= $model->header->text ?>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>

<?= $this->renderFile('@app/views/main/component/_' . $id . '.php', ['model' => $model, 'url' => $url]) ?>

<?php if ($product) { ?>
<section class="c-footer">
    <div class="container">
        <div class="row">
            <?php if ($model->product->type === 1) { ?>
            <div class="col-xl-3 col-lg-5">
                <div class="c-footer__img-product-1" style="background-image: url(<?= Url::to($url . 'product-1.png?v=1') ?>);"></div>
            </div>
            <div class="col-xl-4 offset-xl-1 col-lg-6 offset-lg-1">
                <div class="c-footer__text c-fz5">
                    <?= $model->product->text ?>
                </div>
                <div class="c-footer__btns">
                    <div class="c-footer__btn">
                        <?= Html::a(Yii::t('app', 'Подробнее'), $product->getUrl('listing'), ['class' => 'btn btn_empty']) ?>
                    </div>
                    <div class="c-footer__btn c-footer__btn_product">
                        <?= $this->renderFile('@app/views/store/default/_product-add-to-cart.php', [
                            'product' => $product,
                            'productSessia' => $product->sessiaByCurrencyIso,
                        ]) ?>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 offset-xl-1">
                <div class="c-footer__img-product-2" style="background-image: url(<?= Url::to($url . 'product-2.png?v=1') ?>);"></div>
            </div>
            <?php } elseif ($model->product->type === 2) { ?>
            <div class="col-lg-6 offset-lg-1">
                <div class="c-footer__img-product c-img-contain c-mb1" style="background-image: url(<?= Url::to($url . 'product.png?v=1') ?>);"></div>
            </div>
            <div class="col-lg-3 offset-lg-1">
                <div class="c-footer__text c-fz5">
                    <?= $model->product->text ?>
                </div>
                <div class="c-footer__btns">
                    <div class="c-footer__btn">
                        <?= Html::a(Yii::t('app', 'Подробнее'), $product->getUrl('listing'), ['class' => 'btn btn_empty']) ?>
                    </div>
                    <div class="c-footer__btn c-footer__btn_product">
                        <?= $this->renderFile('@app/views/store/default/_product-add-to-cart.php', [
                            'product' => $product,
                            'productSessia' => $product->sessiaByCurrencyIso,
                        ]) ?>
                    </div>
                </div>
            </div>
            <?php } elseif ($model->product->type === 3) { ?>
            <div class="col-lg-3 offset-lg-1">
                <div class="c-footer__text c-fz5">
                    <?= $model->product->text1 ?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="c-footer__img-product c-img-contain c-mb1" style="background-image: url(<?= Url::to($url . 'product.png?v=1') ?>);"></div>
                <div class="c-footer__btns c-footer__btns_center c-mb1">
                    <div class="c-footer__btn">
                        <?= Html::a(Yii::t('app', 'Подробнее'), $product->getUrl('listing'), ['class' => 'btn btn_empty']) ?>
                    </div>
                    <div class="c-footer__btn c-footer__btn_product">
                        <?= $this->renderFile('@app/views/store/default/_product-add-to-cart.php', [
                            'product' => $product,
                            'productSessia' => $product->sessiaByCurrencyIso,
                        ]) ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="c-footer__text c-fz5">
                    <?= $model->product->text2 ?>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</section>

<style>
body {
    background-color: #fff;
}
</style>
<?php } ?>

<?php

// https://github.com/michalsnik/aos

$js = <<<JS

AOS.init({
    easing: 'ease',
    duration: 1000,
    delay: 500,
    offset: 0
});

JS;

$this->registerJs($js, View::POS_READY);
