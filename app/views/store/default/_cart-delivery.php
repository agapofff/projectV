<?php

use yii\helpers\Html;

?>

<div class="cart-delivery-radio">
<?php foreach ($delivery_type_list as $item) { ?>
    <div class="cart-delivery-radio__item<?= $model->delivery_type === $item->value ? ' active' : '' ?>" data-type="<?= $item->value ?>"><?= $item->label ?></div>
<?php } ?>
</div>

<?= Html::activeHiddenInput($model, 'delivery_type', ['id' => 'delivery_type']) ?>


<div class="cart-delivery-value">
<?php if (!empty($delivery_value)) { ?>
    <?= $this->renderFile('@app/views/store/default/_cart-delivery-item.php', [
        'delivery_value' => $delivery_value,
        'delivery_id' => $model->delivery_id,
    ]) ?>
<?php } ?>
</div>

<?= Html::activeHiddenInput($model, 'delivery_id', ['id' => 'delivery_id']) ?>
<?= Html::activeHiddenInput($model, 'price_delivery', ['id' => 'delivery_price']) ?>


<?php if ($model->delivery_type === 'delivery') { ?>
    <?php $arr = Yii::$app->params['currency'] !== 'VND' ? ['post_code', 'street', 'home_number', 'room'] : ['street', 'home_number', 'room']; ?>
    <?php foreach ($arr as $val) { ?>
    <div class="cart-form__row">
        <div class="form-group field-name">
            <label class="control-label" for="<?= $val ?>"><?= Html::encode($model->getAttributeLabel($val)) ?></label>
            <?= Html::activeTextInput($model, $val, ['id' => $val, 'class' => 'form-control', 'placeholder' => Html::encode($model->getAttributeLabel($val))]) ?>
            <div class="help-block"></div>
        </div>
    </div>
    <?php } ?>
<?php } ?>


<div class="cart-delivery-popup">
    <div class="cart-delivery-popup__close"></div>
    <?php foreach ($delivery_type_list as $item) { ?>
    <div class="cart-delivery-popup__content" data-type="<?= $item->value ?>">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1">
                    <div class="cart-delivery-popup__title fz4">
                        <?= $item->label ?>
                    </div>
                    <input class="cart-delivery-popup__search" type="text" placeholder="<?= Yii::t('app', 'Поиск по адресу') ?>" />
                    <div class="cart-delivery-popup__inner">
                        <div class="cart-delivery-popup__list">
                        <?php foreach ($item->list as $delivery_value) { ?>
                            <div class="cart-delivery-popup__item<?= $model->delivery_id === $delivery_value->id ? ' active' : '' ?>"
                                 data-type="<?= $item->value ?>"
                                 data-id="<?= $delivery_value->id ?>"
                                 data-price="<?= $delivery_value->price ?>">
                                <?= $this->renderFile('@app/views/store/default/_cart-delivery-item.php', [
                                    'delivery_value' => $delivery_value,
                                ]) ?>
                            </div>
                        <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>
