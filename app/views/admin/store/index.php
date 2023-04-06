<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\web\View;
use app\forms\admin\StoreSearch;
use app\entities\admin\Store;

$this->title = Yii::t('admin', 'Магазины');

?>

<?php Pjax::begin(['scrollTo' => 0, 'timeout' => 10000, 'options' => ['id' => 'page-shops', 'class' => 'page']]) ?>
    <div class="container">
        <?= Html::a(Yii::t('admin', 'Очистить фильтр'), ['/admin/store/index'], ['class' => 'btn btn-dark']) ?>
        <?= Html::a(Yii::t('admin', 'Добавить магазин'), ['/admin/store/add'], ['class' => 'btn btn-warning float-right', 'data-pjax' => 0]) ?>
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
                        return '<span class="badge badge-warning">' . $data->id . '</span>';
                    },
                    'headerOptions' => ['class' => 'id'],
                    'filterOptions' => ['class' => 'id'],
                    'contentOptions' => ['class' => 'id text-left', 'style' => 'width: 5%;'],
                ],
                [
                    'attribute' => 'title',
                    'filter' => StoreSearch::getTitle(),
                    'content' => function($data) {
                        $data->title = empty($data->title) ? 'No name' : $data->title;
                        return Html::a($data->title, ['/admin/store/form', 'id' => $data->id], ['data-pjax' => 0]);
                    },
                    'headerOptions' => ['class' => 'title'],
                    'filterOptions' => ['class' => 'title'],
                    'contentOptions' => ['class' => 'title text-left', 'style' => 'width: 15%;'],
                ],
                [
                    'attribute' => 'type',
                    'filter' => Store::getTypeList(),
                    'content' => function($data) {
                        return $data->getType();
                    },
                    'headerOptions' => ['class' => 'type'],
                    'filterOptions' => ['class' => 'type'],
                    'contentOptions' => ['class' => 'type text-left', 'style' => 'width: 10%;'],
                ],
                [
                    'attribute' => 'currency_iso',
                    'filter' => StoreSearch::getCurrencyIso(),
                    'headerOptions' => ['class' => 'currency_iso'],
                    'filterOptions' => ['class' => 'currency_iso'],
                    'contentOptions' => ['class' => 'currency_iso', 'style' => 'width: 10%;'],
                ],
                [
                    'attribute' => Yii::t('admin', 'Страны'),
                    'content' => function($data) {
                        return StoreSearch::getCountries($data);
                    },
                    'headerOptions' => ['class' => 'countries'],
                    'filterOptions' => ['class' => 'countries'],
                    'contentOptions' => ['class' => 'countries', 'style' => 'width: 20%;'],
                ],
                [
                    'attribute' => Yii::t('app', 'Продукция'),
                    'content' => function($data) {
                        return StoreSearch::getProducts($data);
                    },
                    'headerOptions' => ['class' => 'products'],
                    'filterOptions' => ['class' => 'products'],
                    'contentOptions' => ['class' => 'products', 'style' => 'width: 20%;'],
                ],
                [
                    'content' => function($data) {
                        return '<i class="delete__icon fas fa-trash-alt" data-id="' . $data->id . '"></i>';
                    },
                    'headerOptions' => ['class' => 'delete'],
                    'filterOptions' => ['class' => 'delete'],
                    'contentOptions' => ['class' => 'delete text-center text-dark', 'style' => 'width: 5%;'],
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
        <?= Html::a(Yii::t('admin', 'Импорт валют'), ['/admin/currency/import'], ['class' => 'btn btn-success mt-3 mr-3', 'data-pjax' => 0]) ?>
        <?= Html::a(Yii::t('admin', 'Импорт стран'), ['/admin/country/import'], ['class' => 'btn btn-primary mt-3 mr-3', 'data-pjax' => 0]) ?>
        <?= Html::a(Yii::t('admin', 'Импорт продукции'), ['/admin/product-sessia/import', 'id' => Yii::$app->params['secret_id']], ['class' => 'btn btn-info mt-3', 'data-pjax' => 0]) ?>
    </div>
<?php Pjax::end() ?>

<?php

$urlDelete = Url::to(['/admin/store/delete']);

$js = <<<JS
$(document).on('click', '.delete__icon', function() {
    var id = $(this).data('id');
    $(this).html('...');
    $.ajax({
        url: '$urlDelete',
        type: 'POST',
        dataType: 'json',
        data: {id: id},
        success: function(data) {
            $.pjax.reload('#page-shops');
        },
    });
});
JS;
$this->registerJs($js, View::POS_READY);
