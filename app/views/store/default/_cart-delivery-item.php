<div class="cart-delivery">
    <div class="cart-delivery__header">
        <div class="cart-delivery__title">
            <?= $delivery_value->params ?>
            <?= !empty($delivery_value->params) && !empty($delivery_value->title) ? '—' : '' ?>
            <?= $delivery_value->title ?>
        </div>
        <div class="cart-delivery__price"><?= $delivery_value->price_currency ?></div>
    </div>
    <?php if (!empty($delivery_value->comment)) { ?>
    <div class="cart-delivery__comment fz5">
        <?= $delivery_value->comment ?>
    </div>
    <?php } ?>
</div>
