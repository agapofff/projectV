<?php

use yii\helpers\Url;

?>

<?= Yii::t('app', 'Ваш заказ #{order_number}', ['order_number' => $orderSessia->id]) ?>
<?= Yii::t('app', 'Статус: {payment_status}', ['payment_status' => $paymentStatus]) ?>
<?= Yii::t('app', 'Способ получения: {delivery_type}', ['delivery_type' => $order->getDeliveryTypeName()]) ?>
<?php if (!empty($orderResponse->delivery_address)) { ?><?= $orderResponse->delivery_address ?><?php } ?>
<?php if (!empty($orderResponse->delivery_method->comment)) { ?><?= $orderResponse->delivery_method->comment ?><?php } ?>

<?php foreach ($order->products as $orderProduct) { ?>
<?php
$product = $orderProduct->product;
$productCover = $product->coverByCurrencyIso;
$translate = $product->translateByLangId;
?>
<?= $translate->title ?>
<?= $orderProduct->getPrice() ?> х <?= Yii::t('app', '{quantity, plural, one{# штука} few{# штуки} many{# штук} other{# штук}}', ['quantity' => $orderProduct->quantity]) ?>
<?php } ?>

<?= Yii::t('app', 'Товары') ?>: <?= $order->getPriceProducts() ?>
<?= Yii::t('app', 'Скидка') ?>: <?= $order->getPriceDiscount() ?>
<?= Yii::t('app', 'Доставка') ?>: <?= $order->getPriceDelivery() ?>
<?= Yii::t('app', 'Итого') ?>: <?= $order->getPriceTotal() ?>

<?= Yii::t('app', 'Перейти на сайт') ?>
<?= Url::to(['/main/site/index'], true) ?>
