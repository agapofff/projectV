<?php

use app\repositories\ProductRepository;
use yii\helpers\Html;

if (!isset($request->payment_service)) {
    $payment_service = Yii::t('admin', 'Оплата через платежный шлюз');
} elseif ((int)$request->payment_service === 5) {
    $payment_service = Yii::t('admin', 'Оплата при получении');
} else {
    $payment_service = Yii::t('admin', 'Оплата через платежный шлюз');
}

?>

<?php if (isset($request->delivery_address)) { ?>
<div class="row mb-2">
    <div class="col-4"><?= Yii::t('admin', 'Страна: {country}', ['country' => '</div><div class="col-8">' . $request->delivery_address->country_name]) ?></div>
    <div class="col-4"><?= Yii::t('admin', 'Город: {city}', ['city' => '</div><div class="col-8">' . $request->delivery_address->city_name]) ?></div>
</div>

<div class="row mb-2">
    <div class="col-4"><?= Yii::t('admin', 'Имя: {name}', ['name' => '</div><div class="col-8">' . $request->name]) ?></div>
    <div class="col-4"><?= Yii::t('admin', 'E-mail: {email}', ['email' => '</div><div class="col-8">' . $request->email]) ?></div>
    <div class="col-4"><?= Yii::t('admin', 'Телефон: {phone}', ['phone' => '</div><div class="col-8">' . $request->phone]) ?></div>
</div>

<div class="row mb-2">
    <div class="col-4"><?= Yii::t('admin', 'Способ получения: {delivery_method}', ['delivery_method' => '</div><div class="col-8">' . (empty($request->delivery_address->post_code) ? Yii::t('app', 'Самовывоз') : Yii::t('app', 'Доставка'))]) ?></div>
    <div class="col-4"><?= Yii::t('admin', 'Тип оплаты: {payment_service}', ['payment_service' => '</div><div class="col-8">' . $payment_service]) ?></div>
</div>

<?php if ($delivery_address = $request->delivery_address && !empty($delivery_address->post_code)) { ?>
<div class="row mb-2">
    <div class="col-4"><?= Yii::t('admin', 'Индекс: {index}', ['index' => '</div><div class="col-8">' . $delivery_address->post_code]) ?></div>
    <div class="col-4"><?= Yii::t('admin', 'Улица: {street}', ['street' => '</div><div class="col-8">' . $delivery_address->street]) ?></div>
    <div class="col-4"><?= Yii::t('admin', 'Дом: {house}', ['house' => '</div><div class="col-8">' . $delivery_address->home_number]) ?></div>
    <div class="col-4"><?= Yii::t('admin', 'Квартира: {apartment}', ['apartment' => '</div><div class="col-8">' . $delivery_address->room]) ?></div>
</div>
<?php } ?>

<?php foreach ($request->products as $product) { ?>
<div class="media text-muted pb-2">
    <?php $modelRepository = new ProductRepository(); ?>
    <?php if ($model = $modelRepository->get($product->product_id)) { ?>
    <?= Html::a('', $model->getUrl('log'), ['style' => 'background-image: url("' . $model->coverByCurrencyIso->getUrlPrev() . '"); width: 32px; height: 32px;', 'class' => 'mr-2 rounded']) ?>
    <p class="media-body pb-2 mb-0 small lh-125">
        <strong class="d-block text-gray-dark"><?= Html::a($product->name, $model->getUrl('log')) ?></strong>
    <?php } else { ?>
    <img class="mr-2 rounded bg-primary" style="width: 32px; height: 32px;" data-holder-rendered="true" />
    <p class="media-body pb-2 mb-0 small lh-125">
        <strong class="d-block text-gray-dark"><?= $product->name ?></strong>
    <?php } ?>
        <?= Yii::t('admin', '{quantity, plural, one{# штука} few{# штуки} many{# штук} other{# штук}}', ['quantity' => $product->quantity]) ?> —
        <?= Yii::$app->formatter->asCurrency(
            $product->price,
            $product->currency_code,
            [\NumberFormatter::MAX_SIGNIFICANT_DIGITS => 100]
        ) ?>
    </p>
</div>
<?php } ?>
<?php } ?>
