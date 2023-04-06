<?= Yii::t('admin', 'Страна: {country}', ['country' => $request->delivery_address->country_name]) ?><br>
<?= Yii::t('admin', 'Город: {city}', ['city' => $request->delivery_address->city_name]) ?><br>
<br>
<?= Yii::t('admin', 'Имя: {name}', ['name' => $request->name]) ?><br>
<?= Yii::t('admin', 'E-mail: {email}', ['email' => $request->email]) ?><br>
<?= Yii::t('admin', 'Телефон: {phone}', ['phone' => $request->phone]) ?><br>
<br>
<?= Yii::t('admin', 'Способ получения: {delivery_method}', ['delivery_method' => (empty($request->delivery_address->post_code) ? Yii::t('app', 'Самовывоз') : Yii::t('app', 'Доставка'))]) ?><br>
<?= Yii::t('admin', 'Тип оплаты: {payment_service}', ['payment_service' => $payment_service]) ?><br>
<br>
<?php if ($delivery_address = $request->delivery_address && !empty($delivery_address->post_code)) { ?>
<br>
<?= Yii::t('admin', 'Индекс: {index}', ['index' => $delivery_address->post_code]) ?><br>
<?= Yii::t('admin', 'Улица: {street}', ['street' =>  $delivery_address->street]) ?><br>
<?= Yii::t('admin', 'Дом: {house}', ['house' => $delivery_address->home_number]) ?><br>
<?= Yii::t('admin', 'Квартира: {apartment}', ['apartment' => $delivery_address->room]) ?><br>
<?php } ?>
<br>
<?php foreach ($request->products as $product) { ?>
<br>
<br>
<?= $product->name ?>
<?= Yii::t('app', '{quantity, plural, one{# штука} few{# штуки} many{# штук} other{# штук}}', ['quantity' => $product->quantity]) ?> —
<?= Yii::$app->formatter->asCurrency(
    $product->price,
    $product->currency_code,
    [\NumberFormatter::MAX_SIGNIFICANT_DIGITS => 100]
) ?>
<?php } ?>
<br>
<br>
<?= Yii::t('admin', 'Открыть в CRM') ?> https://crm.sessia.com/shop/orders/edit/<?= $response_id ?>
