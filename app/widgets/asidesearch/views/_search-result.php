<?php

use yii\helpers\Html;

?>

<?php $i = 1; ?>
<?php foreach ($arr as $product) { ?>
    <?php $i++; ?>
    <?php if ($i === 7) break; ?>

    <?php $cover = $product->coverByCurrencyIso; ?>
    <?php $sessia = $product->sessiaByCurrencyIso; ?>

    <tr class="product-add-to-cart__row">
        <td class="product-add-to-cart__cover">
            <?= Html::a('', $product->getUrl('search'), ['class' => 'product-add-to-cart__img', 'style' => 'background-image: url("' . $cover->getUrlPrev() . '")']) ?>
        </td>
        <td class="product-add-to-cart__title">
            <?= Html::a($product->title, $product->getUrl('search'), ['class' => '']) ?>
        </td>
        <td class="product-add-to-cart__total-price">
            <?= $sessia->getPriceFormatter(1) ?>
        </td>
        <td class="product-add-to-cart__half"></td>
    </tr>
    <tr class="product-add-to-cart__hr"><td colspan="4"></td></tr>

<?php } ?>
