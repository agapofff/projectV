<?php

use yii\web\View;

$js = <<<JS

class DataLayerMainSiteIndex {

    constructor() {
        this.slider = $('.collection__list-img');
        this.onLoad();
        this.onClickByProductLink();
    }

    onLoad() {
        var self = this;
        this.slider.on('init', function() {
            self.getParamsForView();
        });
        this.slider.on('afterChange', function() {
            self.getParamsForView();
        });
    }

    getParamsForView() {
        var el = this.slider.find('.slick-current').find('a'),
            currencyCode = el.data('currency-code'),
            impressions = {
                name: el.data('name'),
                id: el.data('id'),
                price: el.data('price'),
                brand: el.data('brand'),
                category : el.data('category'),
                variant: el.data('variant'),
                list: 'home',
                position: el.data('position')
            };
        dataLayerSite.pushEventViewInList(currencyCode, impressions);
    }

    onClickByProductLink() {
        $(document).on('click', '.collection__item-link-img, .collection__product-btn', function() {
            var el = $(this),
                name = el.data('name'),
                id = el.data('id'),
                price = el.data('price'),
                brand = el.data('brand'),
                category = el.data('category'),
                collection = el.data('collection'),
                variant = el.data('variant'),
                list = 'home',
                position = el.data('position');
            dataLayerSite.pushEventClickFromList(list, name, id, price, brand, category, collection, variant, position);
        });
    }
}

var dataLayerMainSiteIndex = new DataLayerMainSiteIndex();

JS;
$this->registerJs($js, View::POS_READY, 'data-layer-main-site-index');
