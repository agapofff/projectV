<?php

use yii\web\View;

$js = <<<JS

class DataLayerProductsStoreView {

    constructor() {
        this.onLoad();
        this.onClickByAddToCartBtn();
    }

    onLoad() {
        var el = $('.store_item'),
            list =  el.data('list'),
            name = el.data('name'),
            id = el.data('id'),
            price = el.data('price'),
            brand = el.data('brand'),
            category = el.data('category'),
            collection = el.data('collection'),
            variant = el.data('variant');
        dataLayerSite.pushEventViewProduct(list, name, id, price, brand, category, collection, variant);
    }

    onClickByAddToCartBtn() {
        $(document).on('click', '.product-quantity__plus, .product-quantity__value_text', function(event) {
            if (event.target.className.indexOf('product-quantity__value_text') + 1) {
                var quantity = 1;
            } else {
                var quantity = +$(this).parents('.product-quantity').find('.product-quantity__value').text() + 1;
            }
            var el = $('.store_item'),
                currencyCode = el.data('currency-code'),
                name = el.data('name'),
                id = el.data('id'),
                price = el.data('price'),
                brand = el.data('brand'),
                category = el.data('category'),
                collection = el.data('collection'),
                variant = el.data('variant'),
                quantity = quantity;
            dataLayerSite.pushEventAddToCart(currencyCode, name, id, price, brand, category, collection, variant, quantity);
        });
    }

    onClickByOneClickFormBtn() {
        var el = $('.store_item'),
            products = {
                name: el.data('name'),
                id: el.data('id'),
                price: el.data('price'),
                brand: el.data('brand'),
                category: el.data('category'),
                collection: el.data('collection'),
                variant: el.data('variant'),
                quantity: 1
            };
        dataLayerSite.pushEventCheckout(products);
    }
}

var dataLayerProductsStoreView = new DataLayerProductsStoreView();

JS;
$this->registerJs($js, View::POS_READY, 'data-layer-products-store-index');
