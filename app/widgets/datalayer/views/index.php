<?php

use yii\web\View;

$js = <<<JS

class DataLayerSite {

    /**
     * impressions: name, id, price, brand, category, variant, list, position
     * 
     * 'name': name,  // Name or ID is required
     * 'id': id,
     * 'price': price,
     * 'brand': brand,  // Код продукта
     * 'category': category,  // Откуда брать категорию https://take.ms/IjMST
     * 'collection': collection,
     * 'variant': variant,  // Откуда брать вариант https://take.ms/IjMST
     * 'list': list,  // Где показался товар - главная, каталог, магазин
     * 'position': position  // Позиция показа товара
     */
    pushEventViewInList(currencyCode, impressions) {
        dataLayer.push({
            'event': 'productImpressions',
            'ecommerce': {
                'currencyCode': currencyCode,  // Та валюта, в которой идет расчет
                'impressions': impressions
            }
        });
    }

    pushEventClickFromList(list, name, id, price, brand, category, collection, variant, position) {
        dataLayer.push({
            'event': 'productClick',
            'ecommerce': {
                'click': {
                    'actionField': {'list': list},  // Откуда кликнули на товар: главная, каталог, магазин
                    'products': [{
                        'name': name,
                        'id': id,
                        'price': price,
                        'brand': brand,
                        'category': category,
                        'collection': collection,
                        'variant': variant,
                        'position': position
                    }]
                }
            }
        });
    }

    pushEventViewProduct(list, name, id, price, brand, category, collection, variant) {
        dataLayer.push({
            'event': 'detail',
            'ecommerce': {
                'detail': {
                    'actionField': {'list': list},
                    'products': [{
                        'name': name,
                        'id': id,
                        'price': price,
                        'brand': brand,
                        'category': category,
                        'collection': collection,
                        'variant': variant
                    }]
                }
            }
        });
    }

    pushEventAddToCart(currencyCode, name, id, price, brand, category, collection, variant, quantity) {
        dataLayer.push({
            'event': 'addToCart',
            'ecommerce': {
                'currencyCode': currencyCode,
                'add': {  // 'add' actionFieldObject measures
                    'products': [{  // Adding a product to a shopping cart
                        'name': name,
                        'id': id,
                        'price': price,
                        'brand': brand,
                        'category': category,
                        'collection': collection,
                        'variant': variant,
                        'quantity': quantity
                    }]
                }
            }
        });
    }

    /**
     * products: name, id, price, brand, category, collection, variant, quantity
     */
    pushEventCheckout(products) {
        dataLayer.push({
            'event': 'checkout',
            'ecommerce': {
                'checkout': {
                    'actionField': {'step': 1, 'option': 'orderForm'},
                    'products': products
                }
            }
        });
    }

    /**
     * products: name, id, price, brand, category, collection, variant, quantity, coupon
     */
    pushEventReadySuccess(order_id, revenue, country, city, name, products) {
        dataLayer.push({
            'event': 'productPurchase',
            'ecommerce': {
                'purchase': {
                    'actionField': {
                        'id': order_id,  // Transaction ID
                        'affiliation': 'Online Store',
                        'revenue': revenue,  // Стоимость заказа
                        'country': country,
                        'city': city,
                        'name': name
                    },
                    'products': products
                }
            }
        });
    }

    pushEventReadyFail(order_id, revenue, country, city, name, phone, email) {
        dataLayer.push({
            'event': 'purchaseFail',
            'ecommerce': {
                'id': order_id,  // Transaction ID
                'affiliation': 'Online Store',
                'revenue': revenue,  // Стоимость заказа
                'country': country,
                'city': city,
                'name': name,
                'phone': phone,
                'email': email
            }
        });
    }
}

var dataLayerSite = new DataLayerSite();

JS;
$this->registerJs($js, View::POS_READY, 'data-layer-index');
?>

<?= $this->renderFile('@app/widgets/datalayer/views/_' . $page . '.php', ['params' => $params]) ?>
