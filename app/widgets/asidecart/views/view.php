<?php

use yii\helpers\Url;
use yii\web\View;

?>

<aside class="aside-cart">
    <div class="aside-cart__header">
        <div class="aside-cart__close">
            <?= Yii::t('app', 'Закрыть') ?>
            <div class="aside-cart__close-icon"></div>
        </div>
    </div>
    <div class="aside-cart__content">
        <div class="loader-spinner"></div>
    </div>
</aside>

<?php

$url_cart_aside = Url::to(['/store/default/cart-aside'], true);
$breakPoint = preg_match("(cart)", Yii::$app->request->url) ? 9999 : 991;

$js = <<<JS

class AsideCart {

    constructor() {
        this.close();
        this.open();
        this.change();

        this.breakPoint = $breakPoint;
    }

    close() {
        var self = this;
        $(document).on('click', function(event) {
            if (!$(event.target).closest('.aside-cart').length) {
                $('.aside-cart').removeClass('active');
            }
        });
        $(document).on('click', '.aside-cart__close', function(event) {
            self.openClose();
        });
    }

    open() {
        var self = this;
        $(document).on('click', '.cart-title', function() {

            if ($(window).width() < self.breakPoint) {
                return;
            }

            self.openClose();

            self.update();

            return false;
        });
    }

    openClose() {
        $('.aside-cart').toggleClass('active');
    }

    change() {
        var self = this;
        $(document).on('click', '.aside-cart.active .product-add-to-cart__minus, .aside-cart.active .product-add-to-cart__plus, .aside-cart.active .cart-product__delete', function() {
            setTimeout(function() {
                self.update();
            }, 100);
        });
        $(document).on('change', '.aside-cart.active .product-add-to-cart__value', function() {
            setTimeout(function() {
                self.update();
            }, 100);
        });
    }

    update() {
        $.ajax({
            type: 'POST',
            url: '$url_cart_aside',
            beforesend: function() {
                $('.aside-cart__content').addClass('loading');
            },
            success: function(data) {
                $('.aside-cart__content').removeClass('loading').html(data);
            }
        });
    }
}

var asideCart = new AsideCart();

JS;
$this->registerJs($js, View::POS_READY);
