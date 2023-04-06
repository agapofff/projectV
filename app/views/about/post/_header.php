<?php

use yii\widgets\Menu;

?>

<section class="section page__section-header-default">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <h1 class="section__title"><?= Yii::t('app', 'События') ?></h1>
            </div>
        </div>
    </div>

    <nav class="filter">
        <div class="container">
            <div class="row">
                <div class="filter__wrapper">
                    <div class="filter__content">
                        <?= Menu::widget([
                            'items' => [
                                [
                                    'label' => Yii::t('app', 'Мероприятия'),
                                    'url' => ['/events/index', 'type' => 'activity'],
                                ],
                                [
                                    'label' => Yii::t('app', 'Новости'),
                                    'url' => ['/events/index', 'type' => 'news'],
                                ],
                            ],
                            'options' => [
                                'class' => 'filter__list',
                                'tag' => 'ul',
                            ],
                            'itemOptions' => [
                                'class' => 'filter__item',
                                'tag' => 'li',
                            ],
                            'linkTemplate' => '<a href="{url}" class="filter__link">{label}</a>',
                            'activeCssClass' => 'filter__item_active',
                            'encodeLabels' => false,
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</section>

<?= $this->renderFile('@app/views/layouts/_js-filter.php'); ?>
