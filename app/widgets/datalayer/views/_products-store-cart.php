<?php

use yii\web\View;

$js = <<<JS

class DataLayerProductsStoreCart {

    onClickByCheckoutBtn() {

        var products = [];

        var arr = cart.CART;
        var i = 1;
        for (var key in arr) {
            var arr2 = arr[key];
            for (var j = 0; j < arr2.length; j++) {
                var val = arr2[j];
                products[j] = {
                    name: val.name,
                    id: val.product_id,
                    price: val.price,
                    brand: val.brand,
                    category: val.category,
                    collection: val.collection,
                    variant: val.variant,
                    quantity: val.quantity
                }
            }
            break;
        }
        dataLayerSite.pushEventCheckout(products);
    }
}

var dataLayerProductsStoreCart = new DataLayerProductsStoreCart();

JS;
$this->registerJs($js, View::POS_READY, 'data-layer-products-store-cart');
