<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;
use app\forms\admin\ProductSearch;

$this->title = Yii::t('app', 'Продукция');

?>

<?php Pjax::begin(['scrollTo' => 0, 'timeout' => 10000, 'options' => ['id' => 'page-shops', 'class' => 'page']]) ?>
    <div class="container">
        <?php if (empty($sort) || $sort !== '1') { ?>

            <?= Html::a(Yii::t('app', 'Очистить фильтр'), ['/admin/product/index'], ['class' => 'btn btn-dark']) ?>
            <?php if (Yii::$app->user->can('admin')) { ?>
            <?= Html::a(Yii::t('app', 'Сортировка'), ['/admin/product/index', 'sort' => true], ['class' => 'btn btn-dark float-right', 'data-pjax' => 0]) ?>
            <?php } ?>
            <?= Html::a(Yii::t('app', 'Добавить товар'), ['/admin/product/add'], ['class' => 'btn btn-dark float-right mr-3', 'data-pjax' => 0]) ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'options' => [
                    'id' => 'table',
                    'class' => 'table-responsive mt-4',
                ],
                'tableOptions' => [
                    'class' => 'table table-bordered table-hover mt-2 bg-white',
                ],
                'summaryOptions' => [
                    'class' => 'text-secondary',
                ],
                'headerRowOptions' => ['class' => 'thead-light'],
                'filterRowOptions' => ['id' => 'filter', 'class' => 'filter bg-light'],
                'columns' => [
                    [
                        'attribute' => Yii::t('app', 'Sessia{br}image', ['br' => '<br>']),
                        'content' => function($data) {
                            return Html::img($data->sessia_img, ['height' => 50]);
                        },
                        'headerOptions' => ['class' => 'sessia_img'],
                        'filterOptions' => ['class' => 'sessia_img'],
                        'contentOptions' => ['class' => 'sessia_img text-center', 'style' => 'width: 10%;'],
                        'encodeLabel' => false,
                    ],
                    [
                        'attribute' => 'sessia_title',
                        'content' => function($data) {
                            return Html::a(
                                $data->sessia_title,
                                ProductSearch::getLink($data),
                                ['class' => 'badge badge-info', 'style' => 'text-align: left; white-space: unset; width: auto;', 'data-pjax' => 0]
                            );
                        },
                        'headerOptions' => ['class' => 'sessia_title'],
                        'filterOptions' => ['class' => 'sessia_title'],
                        'contentOptions' => ['class' => 'sessia_title', 'style' => 'width: 25%;'],
                        'encodeLabel' => false,
                    ],
                    [
                        'attribute' => 'sessia_vendor_code',
                        'headerOptions' => ['class' => 'sessia_vendor_code'],
                        'filterOptions' => ['class' => 'sessia_vendor_code'],
                        'contentOptions' => ['class' => 'sessia_vendor_code', 'style' => 'width: 15%;'],
                    ],
                    [
                        'attribute' => 'category',
                        'filter' => ProductSearch::getCategoryList(),
                        'content' => function($data) {
                            return ProductSearch::getCategory($data);
                        },
                        'headerOptions' => ['class' => 'category'],
                        'filterOptions' => ['class' => 'category'],
                        'contentOptions' => ['class' => 'category', 'style' => 'width: 15%;'],
                    ],
                    [
                        'attribute' => 'collection',
                        'filter' => ProductSearch::getCollectionList(),
                        'content' => function($data) {
                            return ProductSearch::getCollection($data);
                        },
                        'headerOptions' => ['class' => 'collection'],
                        'filterOptions' => ['class' => 'collection'],
                        'contentOptions' => ['class' => 'collection', 'style' => 'width: 15%;'],
                    ],
                    [
                        'attribute' => Yii::t('app', 'Магазины - Товар{br}Страны', ['br' => '<br>']),
                        'content' => function($data) {
                            return ProductSearch::getCountries($data);
                        },
                        'headerOptions' => ['class' => 'countries'],
                        'filterOptions' => ['class' => 'countries'],
                        'contentOptions' => ['class' => 'countries', 'style' => 'width: 35%;'],
                        'encodeLabel' => false,
                    ],
                ],
                'pager' => [
                    'firstPageLabel' => true,
                    'lastPageLabel' => true,
                    'prevPageLabel' => '<i class="fas fa-angle-left"></i>',
                    'nextPageLabel' => '<i class="fas fa-angle-right"></i>',
                    'maxButtonCount' => 5,
                    // Customzing options for pager container tag
                    'options' => [
                        'tag' => 'div',
                        'class' => 'pagination',
                        'id' => 'pager-container',
                    ],
                    // Customzing CSS class for pager link
                    'linkOptions' => ['class' => 'page-link'],
                    'linkContainerOptions' => ['class' => 'page-item'],
                    'activePageCssClass' => 'active',
                    'disabledPageCssClass' => 'disabled',
                    'disabledListItemSubTagOptions' => ['class' => 'page-link'],
                ],
            ]) ?>

        <?php } else { ?>

            <div class="row">
                <div class="col-12">
                    <?= Html::a(Yii::t('app', 'Листинг'), ['/admin/product/index'], ['class' => 'btn btn-dark float-right', 'data-pjax' => 0]) ?>
                </div>
            </div>
            <ul class="list-group mt-5">
            <?php foreach ($dataProvider->getModels() as $val) { ?>
                <li id="items[]_<?= $val->id ?>" class="list-group-item item-<?= $val->id ?>" data-id="<?= $val->id ?>">
                    <div class="handle" style="background: url(<?= $val->sessia_img ?>) 50% 50% no-repeat;"></div>
                    <div class="title"><?= $val->sessia_title ?></div>
                </li>
            <?php } ?>
            </ul>
            <style>
                .list-group { display: block; }
                .list-group-item { display: inline-block !important; vertical-align: top !important; padding: 10px 5px; width: 100px; height: 120px; }
                .handle { margin: 0; width: 80px; height: 80px; background-size: contain !important; }
                .title { font-size: 10px; text-align: center; text-overflow: ellipsis; white-space: nowrap; overflow: hidden; margin-top: 5px; }
            </style>

        <?php } ?>
    </div>
<?php Pjax::end() ?>

<?php if (!empty($sort)) { ?>
    <?= $this->renderFile('@app/views/admin/_js__admin.php', [
        'url' => 'admin/product',
        'sortable' => true,
        'delete' => false,
        'axis' => '',
    ]) ?>
<?php } ?>
