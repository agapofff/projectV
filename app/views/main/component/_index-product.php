<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="component component-product">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="component-product__img-product-1" data-aos="fade" style="background-image: url(<?= Url::to($url . 'product-img-1.png?v=1') ?>);"></div>
            </div>
            <div class="col-lg-6">
                <div class="component-product__title fz3" data-aos="slide-up">
                    <?= $model->product->title ?>
                </div>
                <div class="row">
                    <div class="col-lg-10 offset-lg-1">
                        <div class="component-product__text fz5" data-aos="slide-up">
                            <?= $model->product->text ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="component-product__img-product-2" data-aos="fade" style="background-image: url(<?= Url::to($url . 'product-img-2.png?v=1') ?>);"></div>
            </div>
        </div>
        <div class="component-product__btns">
            <div class="component-product__btn" data-aos="slide-up">
                <?= Html::a(Yii::t('app', 'Подробнее'), $product->getUrl('listing'), ['class' => 'btn btn_empty']) ?>
            </div>
            <div class="component-product__btn" data-aos="slide-up">
                <?php $quantity = $product->orderProductQuantity; ?>
                <div class="product__btn-cart">
                    <div class="product-quantity product-quantity_card<?= $quantity > 0 ? '' : ' product-quantity_zero' ?>" data-id="<?= $product->id ?>">
                        <div class="product-quantity__minus"></div>
                        <div class="product-quantity__value product-quantity__value_text" data-value="<?= $quantity ?>" data-default="<?= Yii::t('app', 'Купить') ?>">
                            <?= $quantity > 0 ? $quantity : Yii::t('app', 'Купить') ?>
                        </div>
                        <div class="product-quantity__plus"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
