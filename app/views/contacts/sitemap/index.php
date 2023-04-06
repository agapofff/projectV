<?php

use yii\helpers\Html;
use app\services\main\SiteService;

?>

<div class="usual-page sitemap">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="sitemap__title sitemap__title_first fz3"><?= Yii::t('app', 'Главная') ?></h2>
            </div>
            <?php $_type = 'main'; ?>
            <?php $_subtype = 'main'; ?>
            <?php foreach ($urls as $key => $url) { ?>
            <?php $type = $url['url']['type']; ?>
            <?php if ($_type !== $type) { ?>
        </div>
        <div class="row">
            <div class="col-12">
                <h2 class="sitemap__title fz4"><?= SiteService::getMenuLabel($type) ?></h2>
            </div>
            <?php } ?>
            <?php $_type = $type; ?>
            <?php if (preg_match("(store|mass-media|blog)", $url['url']['subtype'])) { ?>
                <?php if ((Yii::$app->params['currency'] !== 'RUB' && !preg_match("(mass-media)", $url['url']['subtype'])) || Yii::$app->params['currency'] === 'RUB') { ?>
                    <div class="col-12">
                        <h3 class="sitemap__subtitle">
                            <?= Html::a(strip_tags($url['url']['title']) , $url['url']['loc']) ?>
                        </h3>
                    </div>
                <?php } ?>
            <?php } elseif ($url['url']['subtype'] !== 'sitemap') { ?>
                <?php if ((Yii::$app->params['currency'] !== 'RUB' && !preg_match("(post)", $url['url']['subtype'])) || Yii::$app->params['currency'] === 'RUB') { ?>
                    <div class="col-sm-6 col-md-3">
                        <div class="sitemap__item">
                            <?= Html::a(strip_tags($url['url']['title']), $url['url']['loc']) ?>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>
