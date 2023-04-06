<?php

use app\forms\store\CartForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

$model = new CartForm($order);

?>

<?php $form = ActiveForm::begin([
    'validateOnBlur' => false,
    'id' => 'cart-form',
    'options' => ['class' => 'form cart-form', 'autocomplete' => 'off'],
]); ?>

    <div class="cart-form__block">
        <div class="cart-form__row">
            <?= $form->field($model, 'country_name')
                ->textInput(['placeholder' => Html::encode($model->getAttributeLabel('country_name')), 'id' => 'country_name', 'class' => 'form-control country-title', 'readonly' => true]) ?>
            <?= $form->field($model, 'country_id')
                ->label(false)
                ->hiddenInput(['id' => 'country_id']) ?>
        </div>
        <div class="cart-form__row">
            <?= $form->field($model, 'city_name')
                ->textInput(['placeholder' => empty($model->city_name) ? Html::encode($model->getAttributeLabel('city_name')) : $model->city_name, 'id' => 'city_name']) ?>
            <?= $form->field($model, 'city_id')
                ->label(false)
                ->hiddenInput(['id' => 'city_id']) ?>
        </div>
    </div>
    <div class="cart-form__block">
        <div class="cart-form__row">
            <?= $form->field($model, 'name')
                ->textInput(['placeholder' => Html::encode($model->getAttributeLabel('name')), 'id' => 'name']) ?>
        </div>
        <div class="cart-form__row">
            <?= $form->field($model, 'email')
                ->textInput(['placeholder' => Html::encode($model->getAttributeLabel('email')), 'id' => 'email']) ?>
        </div>
        <div class="cart-form__row">
            <?= $form->field($model, 'phone')->widget(MaskedInput::class, [
                'name' => 'phone',
                'mask' => $model->phone_code . ' ' . str_replace('_', '9', $model->phone_mask),
                'options' => [
                    'id' => 'phone',
                    'placeholder' => $model->phone_code . ' ' . $model->phone_mask,
                ],
            ]) ?>
        </div>
    </div>

    <div class="cart-form__block">
        <div id="cart-delivery" class="cart-form__cart-delivery"></div>
    </div>

    <div class="cart-form__block">
        <div class="row">
            <div class="col-md-4">
                <div id="cart-promo-code"></div>
            </div>
            <div class="col-md-6 offset-md-2">
                <div id="cart-price"></div>
            </div>
        </div>
    </div>

    <div id="summary-errors" class="cart-form__summary-errors"></div>

    <?= Html::submitButton(Yii::t('app', 'Оформить заказ'), ['class'=>'btn cart-form__btn', 'id' => 'btn-order-create']) ?>

<?php ActiveForm::end(); ?>
