<?php if ($productSessia->active === 1) { ?>
    <?php $quantity = ($orderProduct = $product->orderProductQuantity) ? $orderProduct->quantity : 0; ?>
    <div class="product-add-to-cart product-add-to-cart_card<?= $quantity > 0 ? '' : ' product-add-to-cart_zero' ?>" data-id="<?= $product->id ?>">
        <div class="product-add-to-cart__minus"></div>
        <input class="product-add-to-cart__value" type="text" value="<?= $quantity ?>" data-default="0" />
        <div class="product-add-to-cart__plus"></div>
    </div>
<?php } ?>
