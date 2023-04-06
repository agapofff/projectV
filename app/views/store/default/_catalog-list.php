<?php

use yii\helpers\Html;
use yii\helpers\Url;

$productCover = $model->coverByCurrencyIso;
$productSessia = $model->sessiaByCurrencyIso;

if ($translate = $model->translateByLangId) {

$paramsLink = [
    'class' => 'product-item__link btn',
    'data-pjax' => 0,
    'data-currency-code' => Yii::$app->params['currency'],
    'data-name' => str_replace("&nbsp;", " ", $translate->title),
    'data-id' => $model->id,
    'data-price' => $productSessia->price_value ?? 0,
    'data-category' => $model->getCategoryName(),
    'data-collection' => $model->getCollectionName(),
    'data-variant' => $model->getProblem(),
    'data-position' => ++$index,
];

?>

<div class="product-item" data-collection="<?= $model->collection ?>">
    <div class="product-item__media">
        <div class="product-item__img" style="background-image: url('<?= Url::to('@web' . $productCover->getUrl()) ?>');"></div>
        <div class="product-item__properties">
            <div class="product-item__property-title">
                <?= Html::a($model->getCollectionName(), ['/store/default/catalog', 'category' => $model->category, 'collection' => $model->collection], ['class' => 'product-item__property-title-link']) ?>
            </div>
            <?php if ($properties = $translate->getProperties()) { ?>
            <div class="product-item__property-list">
                <div class="product-item__property-item fz6"><?= explode("\n", $translate->properties)[0] ?></div>
            </div>
            <?php } ?>
            <?= Html::a(Yii::t('app', 'Подробнее'), $model->getUrl('listing'), $paramsLink) ?>
        </div>
    </div>
    <div class="product-item__info">
        <?php if ($productSessia) { ?>
        <div class="product-item__price">
            <?= $productSessia->getPriceFormatter(1) ?>
        </div>
        <div class="product-item__product-add-to-cart">
            <?= $this->renderFile('@app/views/store/default/_product-add-to-cart.php', [
                'product' => $model,
                'productSessia' => $productSessia,
            ]) ?>
        </div>
        <?php } else { ?>
        <div class="product-item__price">
            <?= Yii::t('app', 'Нет в продаже') ?>
        </div>
        <?php } ?>
        <?= Html::a($translate->title, $model->getUrl('listing'), str_replace('product-item__link btn', 'product-item__title fz5', $paramsLink)) ?>
    </div>
</div>

<?php

}

?>