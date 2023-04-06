<div class="cart-price">
    <div class="cart-price__row">
        <div class="cart-price__label"><span><?= Yii::t('app', 'Товары') ?></span></div>
        <div class="cart-price__value"><span><?= $order->getPriceProducts() ?></span></div>
    </div>
    <div class="cart-price__row">
        <div class="cart-price__label"><span><?= Yii::t('app', 'Скидка') ?></span></div>
        <div class="cart-price__value"><span><?= $order->getPriceDiscount() ?></span></div>
    </div>
    <div class="cart-price__row">
        <div class="cart-price__label"><span><?= Yii::t('app', 'Доставка') ?></span></div>
        <div class="cart-price__value"><span><?= $order->getPriceDelivery() ?></span></div>
    </div>
    <div class="cart-price__row">
        <div class="cart-price__label"><span><?= Yii::t('app', 'Итого') ?></span></div>
        <div class="cart-price__value"><span><?= $order->getPriceTotal() ?></span></div>
    </div>
</div>
