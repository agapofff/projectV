<?php

use yii\helpers\Url;
use yii\web\View;

$url_count_products_in_cart = Url::to(['/store/default/count-products'], true);

$url_plus_product = Url::to(['/store/order-product/plus'], true);
$url_minus_product = Url::to(['/store/order-product/minus'], true);
$url_change_value_product = Url::to(['/store/order-product/change-value'], true);
$url_remove_product = Url::to(['/store/order-product/remove'], true);

$js = <<<JS

class StoreProducts {

    constructor() {
        this.getQuantityProductsInCart();
        this.plusProduct();
        this.minusProduct();
        this.changeValueProduct();
        this.removeProduct();
    }

    getQuantityProductsInCart() {
        var el_products_quantity = $('.cart-title__products-quantity');
        el_products_quantity.addClass('big-size');
        $.ajax({
            type: 'POST',
            url: '$url_count_products_in_cart',
            success: function(quantity) {
                el_products_quantity.text(quantity);

                if (quantity > 0) {
                    el_products_quantity.addClass('active');
                } else {
                    el_products_quantity.removeClass('active');
                }

                setTimeout(function() {
                    el_products_quantity.removeClass('big-size');
                }, 100);
            }
        });
    }

    plusProduct() {
        var self = this;
        $(document).on('click', '.product-add-to-cart__plus, .product-add-to-cart__value', function(event) {

            if ($(event.target).attr('class') === 'product-add-to-cart__value' && !$(this).parents('.product-add-to-cart').hasClass('product-add-to-cart_zero')) {
                return;
            }

            var product_current = $(this).parents('.product-add-to-cart'),
                product_id = product_current.data('id'),
                product = $('.product-add-to-cart[data-id=' + product_id + ']'),
                product_value = product.find('.product-add-to-cart__value');

            $.ajax({
                type: 'POST',
                url: '$url_plus_product',
                data: {
                    product_id: product_id
                },
                success: function(product_quantity) {
                    self.getQuantityProductsInCart();

                    product.removeClass('product-add-to-cart_zero');
                    product_value.val(product_quantity);
                }
            });
        });
    }

    minusProduct() {
        var self = this;
        $(document).on('click', '.product-add-to-cart__minus', function(event) {

            var product_current = $(this).parents('.product-add-to-cart'),
                product_id = product_current.data('id'),
                product = $('.product-add-to-cart[data-id=' + product_id + ']'),
                product_value = product.find('.product-add-to-cart__value');

            $.ajax({
                type: 'POST',
                url: '$url_minus_product',
                data: {
                    product_id: product_id
                },
                success: function(product_quantity) {
                    self.getQuantityProductsInCart();

                    if (product_quantity >= 1) {
                        product_value.val(product_quantity);
                    } else {
                        product.addClass('product-add-to-cart_zero');
                        product_value.val(product_value.data('default'));
                    }
                }
            });
        });
    }

    changeValueProduct() {
        var self = this;
        $(document).on('change keyup input', '.product-add-to-cart__value', function(event) {

            var product_current = $(this).parents('.product-add-to-cart'),
                product_id = product_current.data('id'),
                value = $(this);

            $.ajax({
                type: 'POST',
                url: '$url_change_value_product',
                data: {
                    product_id: product_id,
                    value: value.val().replace(/[^0-9]/g, "")
                },
                success: function(product_quantity) {
                    self.getQuantityProductsInCart();

                    value.val(product_quantity);
                }
            });
        });
    }

    removeProduct() {
        var self = this;
        $(document).on('click', '.cart-product__delete', function() {

            var product_current = $(this).parents('.cart-product'),
                product_id = product_current.data('id'),
                product = $('.product-add-to-cart[data-id=' + product_id + ']'),
                product_value = product.find('.product-add-to-cart__value');

            $.ajax({
                type: 'POST',
                url: '$url_remove_product',
                data: {
                    product_id: product_id
                },
                success: function() {
                    self.getQuantityProductsInCart();

                    product.addClass('product-add-to-cart_zero');
                    product_value.val(product_value.data('default'));
                }
            });
        });
    }
}

var storeProducts = new StoreProducts();

JS;
$this->registerJs($js, View::POS_READY);
