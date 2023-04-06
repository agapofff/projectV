<?php

use yii\helpers\Html;

?>

<table>
    <tr>
        <td><?= Yii::t('admin', 'Страна: {country}', ['country' => '</td><td>' . $request->delivery_address->country_name]) ?></td>
    </tr>
    <tr>
        <td><?= Yii::t('admin', 'Город: {city}', ['city' => '</td><td>' . $request->delivery_address->city_name]) ?></td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
        <td><?= Yii::t('admin', 'Имя: {name}', ['name' => '</td><td>' . $request->name]) ?></td>
    </tr>
    <tr>
        <td><?= Yii::t('admin', 'E-mail: {email}', ['email' => '</td><td>' . $request->email]) ?></td>
    </tr>
    <tr>
        <td><?= Yii::t('admin', 'Телефон: {phone}', ['phone' => '</td><td>' . $request->phone]) ?></td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
        <td><?= Yii::t('admin', 'Способ получения: {delivery_method}', ['delivery_method' => '</td><td>' . (empty($request->delivery_address->post_code) ? Yii::t('app', 'Самовывоз') : Yii::t('app', 'Доставка'))]) ?></td>
    </tr>
    <tr>
        <td><?= Yii::t('app', 'Тип оплаты: {payment_service}', ['payment_service' => '</td><td>' . $payment_service]) ?></td>
    </tr>
    <?php if ($delivery_address = $request->delivery_address && !empty($delivery_address->post_code)) { ?>
    <tr><td><br></td></tr>
    <tr>
        <td><?= Yii::t('admin', 'Индекс: {index}', ['index' => '</td><td>' . $delivery_address->post_code]) ?></td>
    </tr>
    <tr>
        <td><?= Yii::t('admin', 'Улица: {street}', ['street' => '</td><td>' . $delivery_address->street]) ?></td>
    </tr>
    <tr>
        <td><?= Yii::t('admin', 'Дом: {house}', ['house' => '</td><td>' . $delivery_address->home_number]) ?></td>
    </tr>
    <tr>
        <td><?= Yii::t('admin', 'Квартира: {apartment}', ['apartment' => '</td><td>' . $delivery_address->room]) ?></td>
    </tr>
    <?php } ?>
    <tr><td><br></td></tr>
    <?php foreach ($request->products as $product) { ?>
    <tr>
        <td colspan="2">
            <b><?= $product->name ?></b><br>
            <?= Yii::t('admin', '{quantity, plural, one{# штука} few{# штуки} many{# штук} other{# штук}}', ['quantity' => $product->quantity]) ?> —
            <?= Yii::$app->formatter->asCurrency(
                $product->price,
                $product->currency_code,
                [\NumberFormatter::MAX_SIGNIFICANT_DIGITS => 100]
            ) ?>
        </td>
    </tr>
    <?php } ?>
    <tr><td><br></td></tr>
</table>

<?= Html::a(Yii::t('admin', 'Открыть в CRM'), 'https://crm.sessia.com/shop/orders/edit/' . $response_id, [
    'style' => 'display: inline-block; vertical-align: top; text-decoration: none; background-color: #007bff; color: #fff; padding: 10px 25px; border-radius: 4px;',
]) ?>
