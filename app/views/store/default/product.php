<?php

use yii\web\View;
use yii\helpers\Url;
use yii\helpers\Html;
use ymaker\social\share\widgets\SocialShare;
use app\widgets\datalayer\DataLayer;

$currentUrl = Url::to($product->getUrl(), true);

?>

<div class="product usual-page"
     data-list="<?= $from ?>"
     data-currency-code="<?= Yii::$app->params['currency'] ?>"
     data-name="<?= str_replace("&nbsp;", " ", $productTranslate->title) ?>"
     data-id="<?= $product->id ?>"
     data-price="<?= $productSessia->price_value ?? '' ?>"
     data-category="<?= $product->getCategoryName() ?>"
     data-collection="<?= $product->getCollectionName() ?>"
     data-variant="<?= $product->getProblem() ?>">
    <div class="container">

        <h1 class="product__title fz3">
            <?= $productTranslate->title ?>
        </h1>

        <div class="row">
            <div class="col-lg-6">
                <div class="product__media">
                    <div class="product__media-content">
                        <div class="product__img" style="background-image: url('<?= Url::to('@web' . $productCover->getUrl()) ?>');"></div>
                    </div>
                    <div class="product__media-footer">
                    <?php if ($productSessia) { ?>
                        <div class="product__price fz4">
                            <?= $productSessia->getPriceFormatter(1) ?>
                        </div>
                        <div class="product__product-add-to-cart">
                            <?= $this->renderFile('@app/views/store/default/_product-add-to-cart.php', [
                                'product' => $product,
                                'productSessia' => $productSessia,
                            ]) ?>
                        </div>
                    <?php } else { ?>
                        <div class="product__price fz4">
                            <?= Yii::t('app', 'Нет в продаже') ?>
                        </div>
                    <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="product__info">
                    <div class="product__item">
                        <div class="product__description">
                            <?php if ($issue = $productTranslate->getIssue()) { ?>
                                <div class="product__item-title">
                                    <?= $issue ?>
                                </div>
                            <?php } ?>
                            <?php if ($description = $productTranslate->getDescription()) { ?>
                                <div class="product__text">
                                    <?= $description ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <?php if ($benefits = $productTranslate->getBenefits()) { ?>
                        <div class="product__item">
                            <?= $benefits ?>
                        </div>
                    <?php } ?>

                    <?php if ($video = $productTranslate->getVideo()) { ?>
                        <div class="product__item product__item_video">
                            <?= $video ?>
                        </div>
                    <?php } ?>

                    <?php if ($mainComponents = $productTranslate->getMainComponents()) { ?>
                        <div class="product__item product__item-toggle">
                            <div class="product__item-title product__item-title-toggle" data-id="main-components">
                                <?= Yii::t('app', 'Основные компоненты') ?>
                            </div>
                            <ul class="product-main-components product__text-toggle" id="main-components">
                                <?= $mainComponents ?>
                            </ul>
                        </div>
                    <?php } ?>

                    <?php if ($composition = $productTranslate->getComposition()) { ?>
                        <div class="product__item product__item-toggle">
                            <div class="product__item-title product__item-title-toggle" data-id="composition">
                                <?= Yii::t('app', 'Состав') ?>
                            </div>
                            <div class="product__text-toggle" id="composition">
                                <?= $composition ?>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if ($recommendations = $productTranslate->getRecommendations()) { ?>
                        <div class="product__item product__item-toggle">
                            <div class="product__item-title product__item-title-toggle" data-id="recommendations">
                                <?= $product->collection !== 'switzerland-cosmetics' ? Yii::t('app', 'Рекомендации') : Yii::t('app', 'Ритуал нанесения') ?>
                            </div>
                            <div class="product__text product__text-toggle" id="recommendations">
                                <?= $recommendations ?>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if ($issue = $productTranslate->getIssue()) { ?>
                        <div class="product__item product__item-toggle">
                            <div class="product__item-title product__item-title-toggle" data-id="issue">
                                <?= $product->collection !== 'switzerland-cosmetics' ? Yii::t('app', 'Форма выпуска') : Yii::t('app', 'Объём') ?>
                            </div>
                            <div class="product__text-toggle" id="issue">
                                <div class="product__text">
                                    <?= $issue ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if ($dosage = $productTranslate->getDosage()) { ?>
                        <div class="product__item product__item-toggle">
                            <div class="product__item-title product__item-title-toggle" data-id="dosage">
                                <?= Yii::t('app', 'Дозировка') ?>
                            </div>
                            <div class="product__text product__text-toggle" id="dosage">
                                <?= $dosage ?>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if ($storage = $productTranslate->getStorage()) { ?>
                        <div class="product__item product__item-toggle">
                            <div class="product__item-title product__item-title-toggle" data-id="storage">
                                <?= Yii::t('app', 'Хранение') ?>
                            </div>
                            <div class="product__text product__text-toggle" id="storage">
                                <?= $storage ?>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if ($documents = $product->documentsByLangId) { ?>
                        <div class="product__item product__item-toggle">
                            <div class="product__item-title product__item-title-toggle" data-id="documents">
                                <?= Yii::t('app', 'Документы') ?>
                            </div>
                            <div class="product__text-toggle" id="documents">
                                <ul class="product-properties">
                                    <?php foreach ($documents as $document) { ?>
                                        <li class="product-properties__item">
                                            <i></i> <?= Html::a($document->title, $document->getUrL(), ['class' => 'product-properties__link', 'target' => '_blank']) ?>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->renderFile('@app/views/layouts/_js-share.php') ?>

<?= DataLayer::widget(['page' => 'products-store-view']) ?>

<?php

$js = <<<JS

class Product {

    constructor() {
        this.loaded();
        this.showAndHideInfo();
    }

    loaded() {
        $('.store').addClass('store_loaded');
    }

    // Просмотр информации о продукции в скрытых блоках
    showAndHideInfo() {
        $(document).on('click', '.product__item-toggle', function() {
            if (!$(this).find('.product__item-title-toggle_active').length) {
                $(this).addClass('product__item-toggle_active');
                $(this).find('.product__item-title-toggle').addClass('product__item-title-toggle_active');
                $(this).find('.product__text-toggle').addClass('product__text-toggle_active');
            } else {
                if ($(event.target).closest('.product__item-title-toggle').length) {
                    $(this).removeClass('product__item-toggle_active');
                    $(this).find('.product__item-title-toggle').removeClass('product__item-title-toggle_active');
                    $(this).find('.product__text-toggle').removeClass('product__text-toggle_active');
                }
            }
        });
    }
}

var product = new Product();

JS;
$this->registerJs($js, View::POS_READY, 'product');
