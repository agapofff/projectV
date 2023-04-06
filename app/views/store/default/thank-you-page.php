<?php

use app\widgets\datalayer\DataLayer;
use yii\helpers\Html;

if ($order->status === 'success') {
    $status = 'success';
    $title = Yii::t('app', 'Спасибо за ваш заказ!');
    $text = '<h2 class="thank-you-page__text fz4">' . Yii::t('app', 'Ваш заказ #{order_number}', ['order_number' => $orderSessia->id]) . '</h2>';
    if (isset($order->request)) {
        echo DataLayer::widget(['page' => 'products-store-ready-success', 'params' => $order]);
    }
} else {
    $status = 'failed';
    $title = Yii::t('app', 'Что-то пошло не так');
    $text = '<div class="thank-you-page__text">' . Html::a(Yii::t('app', 'Корзина'), ['/store/default/cart'], ['class' => 'btn']) . '</div>';
    if (isset($order->request)) {
        echo DataLayer::widget(['page' => 'products-store-ready-fail', 'params' => $order]);
    }
}

$this->title = $title;

?>

<div class="thank-you-page usual-page">
    <div class="container">
        <div class="thank-you-page__wrapper">
            <div class="thank-you-page__icon <?= $status ?>"></div>
            <h1 class="thank-you-page__title fz2"><?= $title ?></h1>
            <?= $text ?>
        </div>
    </div>
</div>
