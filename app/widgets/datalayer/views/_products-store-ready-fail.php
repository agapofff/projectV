<?php

use yii\web\View;

$request = json_decode($params->request);

$revenue = $params->price_delivery + $params->price_total;

$js = <<<JS

class DataLayerProductsStoreReady {

    constructor() {
        this.onLoad();
    }

    /**
     * order_id, revenue, country, city, name, phone, email
     */
    onLoad() {
        dataLayerSite.pushEventReadyFail(
            $params->sessia_id,
            $revenue,
            '{$request->delivery_address->country_name}',
            '{$request->delivery_address->city_name}',
            '$request->name',
            '$request->phone',
            '$request->email'
        );
    }
}

var dataLayerProductsStoreReady = new DataLayerProductsStoreReady();

JS;
$this->registerJs($js, View::POS_READY, 'data-layer-products-store-ready');
