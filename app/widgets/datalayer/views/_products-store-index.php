<?php

use yii\web\View;

$js = <<<JS

class DataLayerProductsStoreIndex {

    constructor() {
        this.onLoad();
        this.onClickByProductLink();
        this.onClickByAddToCartBtn();
    }

    onLoad() {
        var impressions = [];
        var currencyCode = '';

        $('.store__item').each(function(i) {
            var el = $(this).find('a');

            currencyCode = el.data('currency-code');

            impressions[i] = {
                name: el.data('name'),
                id: el.data('id'),
                price: el.data('price'),
                brand: el.data('brand'),
                category: el.data('category'),
                collection: el.data('collection'),
                variant: el.data('variant'),
                list: 'store',
                position: el.data('position')
            };
        });

        dataLayerSite.pushEventViewInList(currencyCode, impressions);
    }

    onClickByProductLink() {
        $(document).on('click', '.store-product__img', function() {
            var el = $(this),
                name = el.data('name'),
                id = el.data('id'),
                price = el.data('price'),
                brand = el.data('brand'),
                category = el.data('category'),
                collection = el.data('collection'),
                variant = el.data('variant'),
                list = 'store',
                position = el.data('position');
            dataLayerSite.pushEventClickFromList(list, name, id, price, brand, category, collection, variant, position);
        });
    }

    onClickByAddToCartBtn() {
        $(document).on('click', '.product-quantity__plus, .product-quantity__value_text', function(event) {
            if (event.target.className.indexOf('product-quantity__value_text') + 1) {
                var quantity = 1;
            } else {
                var quantity = +$(this).parents('.product-quantity').find('.product-quantity__value').text() + 1;
            }
            var el = $(this).parents('.store__item').find('a'),
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
}

var dataLayerProductsStoreIndex = new DataLayerProductsStoreIndex();

JS;
$this->registerJs($js, View::POS_READY, 'data-layer-products-store-index');
