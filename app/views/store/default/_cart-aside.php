<?php

use yii\helpers\Html;

?>

<?php if ($orderProducts = $order->products) { ?>

    <div class="aside-cart__products">
        <?= $this->renderFile('@app/views/store/default/_cart-product.php', [
            'orderProducts' => $orderProducts,
        ]) ?>
    </div>

    <div class="aside-cart__btn-row">
        <div class="aside-cart__total-price"><?= $order->getPriceProducts() ?></div>
        <?= Html::a(Yii::t('app', 'Оформить'), ['/store/default/cart'], ['class' => 'aside-cart__btn btn']) ?>
    </div>

<?php } else { ?>

    <div class="aside-cart__empty">
        <div class="aside-cart__empty-icon-cart">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 21.9 21.1"><path fill="currentColor" d="M21.9 19.8L18.2 5.2l-.2-.8h-2C15.6 1.9 13.4.1 10.9 0c-2.5.1-4.6 1.9-5 4.4h-2L0 19.9v.2c0 .3.1.6.3.8l.3.3H21c.6-.2 1-.8.9-1.4zM10.9 2c1.4 0 2.7 1 3.1 2.4H7.9C8.3 3 9.5 2 10.9 2zM2.3 19.1L5.4 6.4h11l3.2 12.8H2.3z"></path></svg>
        </div>
        <?= Yii::t('app', 'Корзина пуста') ?>
        <div class="aside-cart__empty-icon-smile">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path fill="currentColor" d="M16-.08a16 16 0 1016 16 16 16 0 00-16-16zm0 31a15 15 0 1115-15 15 15 0 01-15 15zm-5-19a1 1 0 11-1 1 1 1 0 011-1zm10 0a1 1 0 11-1 1 1 1 0 011-1zm.478 12.65a.5.5 0 00.425-.565 5.955 5.955 0 00-8.92-4.298 5.637 5.637 0 00-2.9 4.31.5.5 0 10.993.114 4.649 4.649 0 012.402-3.556 4.955 4.955 0 017.435 3.57.5.5 0 00.494.43.567.567 0 00.07-.006h.001z"/></svg>
        </div>
    </div>
    <?= Html::a(Yii::t('app', 'Магазин'), ['/store/default/catalog'], ['class' => 'aside-cart__empty-btn btn btn_empty']) ?>

<?php } ?>
