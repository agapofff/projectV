<?php

use app\widgets\datalayer\DataLayer;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

$this->title = Yii::t('app', 'Корзина');

?>

<div class="cart usual-page">
    <div class="container">

        <?php if ($orderProducts = $order->products) { ?>

        <div class="row">
            <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1">
                <div class="cart__products">
                    <div class="cart__title fz3">
                        <?= Yii::t('app', 'Корзина') ?>
                    </div>
                    <div class="cart__product-header">
                        <div class="cart-product">
                            <div class="cart-product__delete">&nbsp;</div>
                            <div class="cart-product__cover fz6"><?= Yii::t('app', 'Фото') ?></div>
                            <div class="cart-product__title fz6"><?= Yii::t('app', 'Название') ?></div>
                            <div class="cart-product__price fz6"><?= Yii::t('app', 'Цена за штуку') ?></div>
                            <div class="cart-product__quantity fz6"><?= Yii::t('app', 'Количество') ?></div>
                            <div class="cart-product__total-price fz6"><?= Yii::t('app', 'Цена за всё') ?></div>
                        </div>
                    </div>
                    <div id="cart-products" class="cart__product-list">
                        <?= $this->renderFile('@app/views/store/default/_cart-product.php', [
                            'orderProducts' => $order->products,
                        ]) ?>
                    </div>
                </div>
                <div class="cart__making-an-order">
                    <div class="cart__title fz3">
                        <div class="cart__title-icon"></div>
                        <?= Yii::t('app', 'Оформление заказа') ?>
                    </div>
                    <div class="cart__form">
                        <?= $this->renderFile('@app/views/store/default/_cart-form.php', [
                            'order' => $order,
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>

        <?php } else { ?>

        <div class="cart__empty">
            <div class="cart__empty-title fz3"><?= Yii::t('app', 'Корзина пуста') ?></div>
            <?= Html::a(Yii::t('app', 'Добавить товары'), ['/store/default/catalog'], ['class' => 'btn btn_empty']) ?>
        </div>

        <?php } ?>

    </div>
</div>

<?= DataLayer::widget(['page' => 'products-store-cart']) ?>

<?php

$url_cart_product = Url::to(['/store/default/cart-product'], true);
$url_cart_delivery = Url::to(['/store/default/cart-delivery'], true);
$url_cart_promo_code = Url::to(['/store/default/cart-promo-code'], true);
$url_cart_price = Url::to(['/store/default/cart-price'], true);
$url_get_cities = Url::to(['/store/sessia/get-cities'], true);
$url_save_cart_data = Url::to(['/store/order/save-cart-data'], true);
$url_add_promo_code = Url::to(['/store/order/add-promo-code'], true);
$url_remove_promo_code = Url::to(['/store/order/remove-promo-code'], true);
$url_order_create = Url::to(['/store/order/create'], true);

$currency = Yii::$app->params['currency'];

$js = <<<JS

class Cart {

    constructor() {
        this.changeProduct();
        this.updateDelivery();
        this.updatePromoCode();
        this.updatePrice();
        this.cityInPlaceholder();
        this.getCities();
        this.saveEnterData();
        this.openDelivery();
        this.closeDelivery();
        this.searchDelivery();
        this.setDelivery();
        this.addPromoCode();
        this.removePromoCode();
        this.createOrder();
    }

    changeProduct() {
        var self = this;
        $(document).on('click', '.product-add-to-cart__minus, .product-add-to-cart__plus, .cart-product__delete', function() {
            setTimeout(function() {
                self.updateProduct();
                self.updateDelivery();
                self.updatePrice();
            }, 100);
        });
        $(document).on('change', '.product-add-to-cart__value', function() {
            setTimeout(function() {
                self.updateProduct();
                self.updateDelivery();
                self.updatePrice();
            }, 100);
        });
    }

    updateProduct() {
        $.ajax({
            type: 'POST',
            url: '$url_cart_product',
            /*beforeSend: function() {
                $('#cart-products').addClass('loading');
            },*/
            success: function(data) {
                if (data.length) {
                    $('#cart-products').removeClass('loading').html(data);
                } else {
                    location.reload();
                }
            }
        });
    }

    updateDelivery() {
        var self = this;
        $.ajax({
            type: 'POST',
            url: '$url_cart_delivery',
            beforeSend: function() {
                $('#cart-delivery').addClass('loading');
            },
            success: function(data) {
                $('#cart-delivery').removeClass('loading').html(data);
            }
        });
    }

    updatePromoCode() {
        $.ajax({
            type: 'POST',
            url: '$url_cart_promo_code',
            beforeSend: function() {
                $('#cart-promo-code').addClass('loading');
            },
            success: function(data) {
                $('#cart-promo-code').removeClass('loading').html(data);
            }
        });
    }

    updatePrice() {
        $.ajax({
            type: 'POST',
            url: '$url_cart_price',
            beforeSend: function() {
                $('#cart-price').addClass('loading');
            },
            success: function(data) {
                $('#cart-price').removeClass('loading').html(data);
            }
        });
    }

    cityInPlaceholder() {
        var self = this;
        $(document).on('focus', '#city_name', function() {
            $(this).val('');
        }).on('blur', '#city_name', function() {
            if ($('#city_id').val().length) {
                $(this).val($(this).attr('placeholder'));
            }
        });
    }

    getCities() {
        var self = this;
        $('#city_name').autocomplete({
            minLength: 2,
            multiple: false,
            classes: {
                '#city_name': 'highlight'
            },
            source: function (request, response) {
                $.ajax({
                    type: 'POST',
                    url: '$url_get_cities',
                    dataType: 'json',
                    data: {
                        term: request.term
                    },
                    success: function (data) {
                        console.log(data);
                        response(data);
                    }
                });
            },
            select: function (event, ui) {
                var city_name = ui.item.name,
                    city_id = ui.item.id;

                $('#city_name').val(city_name).attr('placeholder', city_name);
                $('#city_id').val(city_id);

                $('#delivery_type').val('');
                $('#delivery_id').val('');
                $('#delivery_price').val('');

                self.saveCartData(true);

                $(event.target).autocomplete("close");
                setTimeout(function() {
                    $(event.target).blur();
                });
            },
            close: function(event, ui) {
                if (event.currentTarget === undefined) {
                    $('#city_name').val('');
                }
            }
        }).data('ui-autocomplete')._renderItem = function (ul, item) {
            var re = new RegExp('(' + $.ui.autocomplete.escapeRegex('|' + this.term) + ')', 'gi'),
                label = '|' + item.name,
                highlightedResult = label.replace(re, '<span class="ui-autocomplete__coincidence">$1</span>').replace('|', '');
            return $('<li class="ui-autocomplete__item"></li>').data('item.autocomplete', item).append('<div class="ui-autocomplete__content">' + highlightedResult + '</div>').appendTo(ul);
        };
    }

    saveEnterData() {
        var self = this;
        $(document).on('change', '#name, #email, #phone, #post_code, #street, #home_number, #room', function() {
            self.saveCartData(false);
        });
    }

    saveCartData(delivery) {
        var self = this;
        var form = $('#cart-form');
        $.ajax({
            type: 'POST',
            url: '$url_save_cart_data',
            dataType: 'json',
            data: form.serialize(),
            /*beforeSend: function() {
                form.addClass('loading');
            },*/
            success: function() {
                //form.removeClass('loading');

                if (delivery) {
                    self.updateDelivery();
                    self.updatePrice();
                }
            }
        });
    }

    openDelivery() {
        var self = this;
        $(document).on('click', '.cart-delivery-radio__item', function() {
            var type = $(this).data('type');
            $('body').addClass('popup-active');
            $('.cart-delivery-popup').addClass('active');
            $('.cart-delivery-popup__content').removeClass('active');
            $('.cart-delivery-popup__content[data-type=' + type + ']').addClass('active');
        });
    }

    closeDelivery() {
        var self = this;
        $(document).on('click', '.cart-delivery-popup__close', function() {
            $('body').removeClass('popup-active');
            $('.cart-delivery-popup').removeClass('active');
            $('.cart-delivery-popup__content').removeClass('active');
        });
    }

    searchDelivery() {
        var self = this;
        $(document).on('keyup', '.cart-delivery-popup__search', function() {
            var term = $(this).val();
            if (term.length > 0) {
                $.map($(this).parents('.cart-delivery-popup__content').find('.cart-delivery-popup__item'), function(item) {
                    var comment = $(item).find('.cart-delivery__comment').text();
                    if (comment.toUpperCase().indexOf(term.toUpperCase()) > 0) {
                        $(item).css('display', 'block');
                    } else {
                        $(item).css('display', 'none');
                    }
                });
            } else {
                $('.cart-delivery-popup__item').css('display', 'block');
            }
        });
    }

    setDelivery() {
        var self = this;
        $(document).on('click', '.cart-delivery-popup__item', function() {

            $('.cart-delivery-popup__item').removeClass('active');
            $(this).addClass('active');


            var type = $(this).data('type'),
                id = $(this).data('id'),
                price = $(this).data('price');

            $('#delivery_type').val(type);
            $('#delivery_id').val(id);
            $('#delivery_price').val(price);

            $('#cart-delivery').addClass('loading');
            $('#cart-price').addClass('loading');

            self.saveCartData(true);

            $('body').removeClass('popup-active');
            $('.cart-delivery-popup').removeClass('active');
            $('.cart-delivery-popup__content').removeClass('active');
        });
    }

    addPromoCode() {
        var self = this;
        $(document).on('click', '#btn-add-promo-code', function() {
            $.ajax({
                type: 'POST',
                url: '$url_add_promo_code',
                data: {
                    code: $('#promo_code').val()
                },
                beforeSend: function() {
                    $('#cart-promo-code').addClass('loading');
                },
                success: function(data) {
                    $('#cart-promo-code').removeClass('loading');
                    self.updatePromoCode();
                    self.updatePrice();
                }
            });
        });
    }

    removePromoCode() {
        var self = this;
        $(document).on('click', '#btn-remove-promo-code', function() {
            $.ajax({
                type: 'POST',
                url: '$url_remove_promo_code',
                beforeSend: function() {
                    $('#cart-promo-code').addClass('loading');
                },
                success: function(data) {
                    $('#cart-promo-code').removeClass('loading');
                    self.updatePromoCode();
                    self.updatePrice();
                }
            });
        });
    }

    createOrder() {
        var self = this;
        var form = $('#cart-form');
        var btn = $('#btn-order-create');
        $(document).on('submit', btn, function() {
            if (!btn.hasClass('.loading')) {
                $.ajax({
                    type: 'POST',
                    url: '$url_order_create',
                    dataType: 'json',
                    data: form.serialize(),
                    beforeSend: function() {
                        btn.addClass('loading');

                        $('.form-group').removeClass('error');
                        $('.help-block').empty();
                        $('#summary-errors').empty();
                    },
                    success: function(data) {
                        btn.removeClass('loading');

                        console.log(data);

                        if (typeof(data.error) !== "undefined") {
                            $.each(data.error, function(val, i) {

                                console.log(val, data.error[val]);

                                var input = $('#' + val);
                                if (val === 0) {
                                    $('#summary-errors').append('<p>' + data.error[val] + '</p>');
                                } else if (input.length) {
                                    self.addError(input, data.error[val]);
                                } else {
                                    var message = '';
                                    $.each(data.error[val], function(error) {
                                        message += data.error[val][error] + '<br>';
                                    });
    
                                    var delivery_address = false;
                                    if (val === 'delivery_address') {
                                        if ($('#post_code').val().length < 1 && '$currency' != 'VND') {
                                            delivery_address = self.addError($('#post_code'), message);
                                        } else if ($('#street').val().length < 1) {
                                            delivery_address = self.addError($('#street'), message);
                                        } else if ($('#home_number').val().length < 1) {
                                            delivery_address = self.addError($('#home_number'), message);
                                        }
                                    }
    
                                    if (!delivery_address) {
                                        $('#summary-errors').append('<p>' + message + '</p>');
                                    }
                                }
                            });
                        } else {
                            window.location.href = data.redirect;
                        }
                    }
                });
            }
            return false;
        });
    }

    addError(input, message) {
        var parent = input.parents('.form-group');
        parent.addClass('error');
        parent.find('.help-block').html('<div class="help-block__message">' + message + '</div>');
        
        return true;
    }
}

var cart = new Cart();

JS;
$this->registerJs($js, View::POS_READY);
