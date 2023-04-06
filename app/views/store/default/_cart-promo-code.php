<?php

use yii\helpers\Html;

?>

<div class="cart-form__row">
    <div class="form-group field-name cart-form__promo-code-field">
        <?= Html::activeTextInput($model, 'promo_code', [
           'id' => 'promo_code',
            'class' => 'form-control',
            'placeholder' => Html::encode($model->getAttributeLabel('promo_code')),
            'disabled' => !empty($order->promo_code),
        ]) ?>
        <div id="btn-<?= empty($order->promo_code) ? 'add' : 'remove' ?>-promo-code" class="cart-form__promo-code-btn"><?= empty($order->promo_code) ? '✔' : '𐄂' ?></div>
        <div class="help-block"></div>
    </div>
</div>
