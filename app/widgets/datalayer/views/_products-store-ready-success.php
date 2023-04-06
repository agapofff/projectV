<?php

use yii\web\View;


$request = json_decode($params->request);

$revenue = $params->price_delivery + $params->price_total;

$products = "[";
foreach ($request->products as $key => $product) {
    $products .= "
    {
        'name': '$product->name',
        'id': $product->product_id,
        'price': $product->price,
        'brand': '$product->brand',
        'category': '$product->category',
        'collection': '$product->collection',
        'variant': '$product->variant',
        'quantity': $product->quantity
    },
    ";
}
$products = substr($products, 0, -1);
$products .= "]";


$js = <<<JS

class DataLayerProductsStoreReady {

    constructor() {
        this.onLoad();
    }
    
    /**
     * order_id, revenue, country, city, name, member_id, products
     */
    onLoad() {
        dataLayerSite.pushEventReadySuccess(
            $params->sessia_id,
            '$revenue',
            '{$request->delivery_address->country_name}',
            '{$request->delivery_address->city_name}',
            '{$request->name}',
            $products
        );
    }
}

var dataLayerProductsStoreReady = new DataLayerProductsStoreReady();

JS;
$this->registerJs($js, View::POS_READY, 'data-layer-products-store-ready');
