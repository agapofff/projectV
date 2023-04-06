<?php

use yii\widgets\Menu;

?>

<div class="catalog-filter">

    <div class="catalog-filter__row">
        <div class="catalog-filter__title">
            <?= Yii::t('app', 'Категории') ?>
        </div>
        <?= str_replace('%2C', ',', Menu::widget([
            'items' => $categories,
            'options' => [
                'id' => 'catalog-filter__list',
                'class' => 'catalog-filter__list categories',
            ],
            'itemOptions' => [
                'class' => 'catalog-filter__item',
            ],
            'linkTemplate' => '<a href="{url}" class="catalog-filter__link">{label}</a>',
            'activeCssClass' => 'active',
            'encodeLabels' => false,
        ])) ?>
    </div>

    <?php if (!empty($sex)) { ?>
        <div class="catalog-filter__row">
            <div class="catalog-filter__title">
                <?= Yii::t('app', 'Пол') ?>
            </div>
            <?= str_replace('%2C', ',', Menu::widget([
                'items' => $sex,
                'options' => [
                    'id' => 'catalog-filter__list',
                    'class' => 'catalog-filter__list',
                ],
                'itemOptions' => [
                    'class' => 'catalog-filter__item',
                ],
                'linkTemplate' => '<a href="{url}" class="catalog-filter__link">{label}</a>',
                'activeCssClass' => 'active',
                'encodeLabels' => false,
            ])) ?>
        </div>
    <?php } ?>

    <?php if (!empty($problems)) { ?>
        <div class="catalog-filter__row">
            <div class="catalog-filter__title">
                <?= Yii::t('app', 'Назначение') ?>
            </div>
            <?= str_replace('%2C', ',', Menu::widget([
                'items' => $problems,
                'options' => [
                    'id' => 'catalog-filter__list',
                    'class' => 'catalog-filter__list',
                ],
                'itemOptions' => [
                    'class' => 'catalog-filter__item',
                ],
                'linkTemplate' => '<a href="{url}" class="catalog-filter__link">{label}</a>',
                'activeCssClass' => 'active',
                'encodeLabels' => false,
            ])) ?>
        </div>
    <?php } ?>

</div>
