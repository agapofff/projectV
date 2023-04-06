<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;
use app\forms\admin\CountrySearch;

$this->title = Yii::t('admin', 'Страны');

?>

<?php Pjax::begin(['scrollTo' => 0, 'timeout' => 10000, 'options' => ['id' => 'page-countries', 'class' => 'page']]) ?>
<div class="container">
    <?= Html::a(Yii::t('admin', 'Очистить фильтр'), ['/admin/country/index'], ['class' => 'btn btn-dark']) ?>
    <?= Html::a(Yii::t('admin', 'Импорт стран'), ['/admin/country/import'], ['class' => 'btn btn-primary float-right', 'data-pjax' => 0]) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => [
            'id' => 'table',
            'class' => 'table-responsive mt-4',
        ],
        'tableOptions' => [
            'class' => 'table table-bordered table-hover mt-2 bg-white'
        ],
        'summaryOptions' => [
            'class' => 'text-secondary'
        ],
        'headerRowOptions' => ['class' => 'thead-light'],
        'filterRowOptions' => ['id' => 'filter', 'class' => 'filter bg-light'],
        'columns' => [
            [
                'attribute' => 'id',
                'content' => function($data) {
                    return '<span class="badge badge-primary">' . $data->id . '</span>';
                },
                'headerOptions' => ['class' => 'id'],
                'filterOptions' => ['class' => 'id'],
                'contentOptions' => ['class' => 'id', 'style' => 'width: 6%;'],
            ],
            [
                'attribute' => 'title',
                'content' => function($data) {
                    return Html::a($data->getLocalTitle(), ['/admin/country/form', 'id' => $data->id], ['data-pjax' => 0]);
                },
                'headerOptions' => ['class' => 'title'],
                'filterOptions' => ['class' => 'title'],
                'contentOptions' => ['class' => 'title', 'style' => 'width: 10%;'],
            ],
            [
                'attribute' => 'domain',
                'filter' => CountrySearch::getDomain(),
                'headerOptions' => ['class' => 'domain'],
                'filterOptions' => ['class' => 'domain'],
                'contentOptions' => ['class' => 'domain', 'style' => 'width: 10%;'],
            ],
            [
                'attribute' => 'iso',
                'headerOptions' => ['class' => 'iso'],
                'filterOptions' => ['class' => 'iso'],
                'contentOptions' => ['class' => 'iso', 'style' => 'width: 6%;'],
            ],
            [
                'attribute' => 'phone_code',
                'headerOptions' => ['class' => 'phone_code'],
                'filterOptions' => ['class' => 'phone_code'],
                'contentOptions' => ['class' => 'phone_code text-right', 'style' => 'width: 12.5%;'],
            ],
            [
                'attribute' => 'phone_mask',
                'headerOptions' => ['class' => 'phone_mask'],
                'filterOptions' => ['class' => 'phone_mask'],
                'contentOptions' => ['class' => 'phone_mask', 'style' => 'width: 12.5%;'],
            ],
            [
                'attribute' => 'store_id',
                'filter' => CountrySearch::getStoreId(),
                'content' => function($data) {
                    return '<span class="badge badge-warning">' . $data->store_id . '</span>';
                },
                'headerOptions' => ['class' => 'store_id'],
                'filterOptions' => ['class' => 'store_id'],
                'contentOptions' => ['class' => 'store_id', 'style' => 'width: 6%;'],
            ],
            [
                'attribute' => Yii::t('admin', 'Магазины'),
                'content' => function($data) {
                    $stores = [];
                    foreach ($data->stores as $val) {
                        $stores[] = '<span class="badge badge-warning">' . $val->id . '</span>';
                    }
                    return implode('<br>', $stores);
                },
                'headerOptions' => ['class' => 'countries'],
                'filterOptions' => ['class' => 'countries'],
                'contentOptions' => ['class' => 'countries', 'style' => 'width: 6%;'],
            ],
            [
                'attribute' => 'lang_id',
                'filter' => CountrySearch::getLangs(),
                'content' => function($data) {
                    if ($lang = $data->lang) {
                        return '<span class="badge badge-success">' . $lang->url . '</span>';
                    }
                    return '';
                },
                'headerOptions' => ['class' => 'langs'],
                'filterOptions' => ['class' => 'langs'],
                'contentOptions' => ['class' => 'langs', 'style' => 'width: 6%;'],
            ],
            [
                'attribute' => 'currency_iso',
                'filter' => CountrySearch::getCurrencies(),
                'content' => function($data) {
                    return '<span class="badge badge-success">' . $data->currency_iso . '</span>';
                },
                'headerOptions' => ['class' => 'currency_iso'],
                'filterOptions' => ['class' => 'currency_iso'],
                'contentOptions' => ['class' => 'currency_iso', 'style' => 'width: 6%;'],
            ],
            [
                'attribute' => 'post_code',
                'headerOptions' => ['class' => 'post_code'],
                'contentOptions' => ['class' => 'post_code', 'style' => 'width: 6%;'],
            ],
            [
                'attribute' => 'active',
                'filter' => CountrySearch::getActive(),
                'content' => function($data) {
                    $arr = [
                        1 => '<i class="active__yes fas fa-check-circle text-success"></i>',
                        0 => '<i class="active__no fas fa-times-circle text-danger"></i>',
                    ];
                    return $arr[$data->active];
                },
                'headerOptions' => ['class' => 'active'],
                'filterOptions' => ['class' => 'active'],
                'contentOptions' => ['class' => 'active', 'style' => 'width: 6%;'],
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
</div>
<?php Pjax::end() ?>
