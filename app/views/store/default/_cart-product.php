<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

<?php foreach ($orderProducts as $orderProduct) { ?>
    <?php if ($product = $orderProduct->product) { ?>
        <?php
        $productCover = $product->coverByCurrencyIso;
        $productSessia = $product->sessiaByCurrencyIso;
        $productTranslate = $product->translateByLangId;
        ?>
        <?php if ($productCover && $productSessia && $productTranslate) { ?>

<div class="cart-product" data-id="<?= $product->id ?>">
    <div class="cart-product__delete">
        <div class="cart-product__delete-icon"></div>
    </div>
    <div class="cart-product__cover">
        <?= Html::a('', $product->getUrl(),
            ['class' => 'cart-product__img', 'style' => 'background-image: url("' . Url::to('@web' . $productCover->getUrl()) . '");']) ?>
    </div>
    <div class="cart-product__title">
        <span>
            <?= $productTranslate->title ?>
        </span>
    </div>

    <div class="cart-product__price">
        <?= $productSessia->getPriceFormatter(1) ?>
    </div>
    <div class="cart-product__quantity">
        <?= $this->renderFile('@app/views/store/default/_product-add-to-cart.php', [
            'product' => $product,
            'productSessia' => $productSessia,
        ]) ?>
    </div>
    <div class="cart-product__total-price" data-price_value="<?= $productSessia->getPriceInteger($orderProduct->quantity) ?>">
        <?= $productSessia->getPriceFormatter($orderProduct->quantity) ?>
    </div>
</div>

        <?php } ?>
    <?php } ?>
<?php } ?>
