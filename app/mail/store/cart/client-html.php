<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

<div style="text-align: center; background-color: #F6F8FB; font-family: Arial, serif; font-weight: 300; color: #344974;">
    <div style="max-width: 800px; min-width: 252px; display: inline-block; vertical-align: top; text-align: left; background: #FFFFFF; padding: 24px;">

        <div style="text-align: center;">
            <?= Html::a(
                Html::img(Url::to('@web/front/img/logo.png?v=1', true), ['style' => 'display: block; width: 143px; height: 24px;']),
                Url::to(['/main/site/index'], true),
                ['style' => 'text-decoration: none; display: inline-block; vertical-align: top;']
            ) ?>
        </div>

        <div style="margin: 24px 0; background-color: #C2CED9; height: 1px;"></div>

        <div style="margin: 24px 0;">
            <div style="margin: 20px 0;">
                <div style="margin: 8px 0; font-size: 24px; line-height: 32px;">
                    <?= Yii::t('app', 'Ваш заказ #{order_number}', ['order_number' => $orderSessia->id]) ?>
                </div>
                <div style="margin: 8px 0; font-size: 16px; line-height: 24px; opacity: .6;">
                    <?= Yii::t('app', 'Статус: {payment_status}', ['payment_status' => $paymentStatus]) ?>
                </div>
            </div>
            <div style="margin: 20px 0;">
                <div style="margin: 8px 0; font-size: 20px; line-height: 28px;">
                    <?= Yii::t('app', 'Способ получения: {delivery_type}', ['delivery_type' => $order->getDeliveryTypeName()]) ?>
                </div>
                <?php if (!empty($orderResponse->delivery_address)) { ?>
                <div style="margin: 8px 0; font-size: 16px; line-height: 24px; opacity: .6;">
                    <?= nl2br($orderResponse->delivery_address) ?>
                </div>
                <?php } ?>
                <?php if (!empty($orderResponse->delivery_method->comment)) { ?>
                <div style="margin: 8px 0; font-size: 16px; line-height: 24px; opacity: .6;">
                    <?= nl2br($orderResponse->delivery_method->comment) ?>
                </div>
                <?php } ?>
            </div>
        </div>

        <div style="margin: 24px 0; background-color: #C2CED9; height: 1px;"></div>

        <div style="margin: 24px 0; font-size: 16px; line-height: 24px;">
            <?php foreach ($order->products as $orderProduct) { ?>
                <?php
                $product = $orderProduct->product;
                $productCover = $product->coverByCurrencyIso;
                $translate = $product->translateByLangId;
                ?>
                <div style="margin: 24px 0;">
                    <?= Html::a(null, Url::to($product->getUrl(), true), ['style' => 'display: inline-block; vertical-align: top; text-decoration: none; width: 44px; height: 44px; margin-right: 24px; background-image: url(' . Url::to($productCover->getUrl(), true) . '); background-size: contain; background-position: center center; background-repeat: no-repeat;']) ?>
                    <div style="display: inline-block; vertical-align: top; width: 70%;">
                        <div>
                            <?= $translate->title ?>
                        </div>
                        <div style="font-size: 14px; line-height: 20px; opacity: .6;">
                            <?= $orderProduct->getPrice() ?>
                            х
                            <?= Yii::t('app', '{quantity, plural, one{# штука} few{# штуки} many{# штук} other{# штук}}', ['quantity' => $orderProduct->quantity]) ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <div style="margin: 24px 0; background-color: #C2CED9; height: 1px;"></div>

        <div style="margin: 24px 0;">
            <div style="margin: 4px 0; font-size: 16px; line-height: 24px;">
                <?= Yii::t('app', 'Товары') ?>: <?= $order->getPriceProducts() ?>
            </div>
            <div style="margin: 4px 0; font-size: 16px; line-height: 24px;">
                <?= Yii::t('app', 'Скидка') ?>: <?= $order->getPriceDiscount() ?>
            </div>
            <div style="margin: 12px 0; font-size: 16px; line-height: 24px;">
                <?= Yii::t('app', 'Доставка') ?>: <?= $order->getPriceDelivery() ?>
            </div>
            <div style="margin: 4px 0; font-size: 16px; line-height: 24px;">
                <?= Yii::t('app', 'Итого') ?>: <?= $order->getPriceTotal() ?>
            </div>
        </div>

        <div style="margin: 24px 0; background-color: #C2CED9; height: 1px;"></div>

        <?= Html::a(
            Yii::t('app', 'Перейти на сайт'),
            Url::to(['/main/site/index'], true),
            ['style' => 'text-decoration: none; display: block; text-align: center; font-size: 16px; line-height: 24px; padding: 8px 24px; background-color: #EA4B94; color: #fff; border-radius: 20px;']
        ) ?>

    </div>
</div>
