<?php

use app\widgets\filter\Filter;
use yii\web\View;
use yii\widgets\Pjax;
use yii\widgets\ListView;
use app\widgets\datalayer\DataLayer;

?>

<?php Pjax::begin(['scrollTo' => 0, 'timeout' => 10000, 'options' => ['id' => 'store-pjax', 'class' => 'catalog usual-page']]); ?>
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-lg-4">
                <div class="catalog__filters catalog-filters">
                    <div class="catalog-filters__title">
                        <div class="catalog-filters__icon"></div>
                        <?= Yii::t('app', 'Фильтры') ?>
                    </div>
                    <div class="catalog-filters__content">
                        <?= Filter::widget([
                            'products' => $products,
                            'category' => $category,
                            'collection' => $collection,
                            'sex' => $sex,
                            'problem' => $problem,
                        ]) ?>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-8">
                <?= ListView::widget([
                    'dataProvider' => $dataProvider,
                    'viewParams' => [],
                    'itemView' => '_catalog-list',
                    'options' => [
                        'tag' => 'div',
                        'class' => 'catalog__list row',
                        'id' => 'store-list',
                    ],
                    'layout' => '{items} {pager}',
                    'itemOptions' => [
                        'tag' => 'div',
                        'class' => 'catalog__item col-xl-4 col-lg-6',
                    ],
                    'emptyText' => '
                        <h1 class="catalog__empty-title fz3">' . Yii::t('app', 'Извините') . '</h1>
                        <h2 class="catalog__empty-subtitle fz5">' . Yii::t('app', 'Ничего не найдено') . '</h2>
                    ',
                    'emptyTextOptions' => [
                        'tag' => 'div',
                        'class' => 'empty col-12',
                    ],
                ]) ?>
                <?php if ($category === 'nutraceuticals') { ?>
                    <?= $this->renderFile('@app/views/store/default/_catalog-nutraceuticals.php', [
                        'problemArr' => $problemArr,
                        'problemModel' => $problemModel,
                    ]) ?>
                <?php } elseif ($category === 'cosmeceuticals') { ?>
                    <?= $this->renderFile('@app/views/store/default/_catalog-cosmeceuticals.php') ?>
                <?php } ?>
            </div>
        </div>
    </div>
    <?= DataLayer::widget(['page' => 'products-store-index']) ?>
<?php Pjax::end(); ?>

<?php

$js = <<<JS

$(document).on('pjax:click', function() {
    $('#store-list').css('opacity', .5);
}).on('pjax:end', function() {
    $('#store-list').css('opacity', 1);
});

$(document).on('click', '.catalog-filters__title', function() {
    $('.catalog-filters__content').toggleClass('active');
});

JS;
$this->registerJs($js, View::POS_READY);
