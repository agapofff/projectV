<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;
use app\forms\admin\StoreSearch;

$this->title = Yii::t('admin', 'Языки');

?>

<?php Pjax::begin(['scrollTo' => 0, 'timeout' => 10000, 'options' => ['id' => 'page-shops', 'class' => 'page']]) ?>
    <div class="container">
        <?= Html::a(Yii::t('admin', 'Очистить фильтр'), ['/lang/default/index'], ['class' => 'btn btn-dark']) ?>
        <?= Html::a(Yii::t('admin', 'Импорт языков'), ['/lang/default/import'], ['class' => 'btn btn-success float-right', 'data-pjax' => 0]) ?>
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
                        return '<span class="badge badge-success">' . $data->id . '</span>';
                    },
                    'headerOptions' => ['class' => 'id'],
                    'filterOptions' => ['class' => 'id'],
                    'contentOptions' => ['class' => 'id', 'style' => 'width: 10%;'],
                ],
                [
                    'attribute' => 'name',
                    'content' => function($data) {
                        return Html::a($data->name, ['/lang/default/form', 'id' => $data->id], ['data-pjax' => 0]);
                    },
                    'headerOptions' => ['class' => 'name'],
                    'filterOptions' => ['class' => 'name'],
                    'contentOptions' => ['class' => 'name', 'style' => 'width: 30%;'],
                ],
                [
                    'attribute' => 'url',
                    'headerOptions' => ['class' => 'url'],
                    'filterOptions' => ['class' => 'url'],
                    'contentOptions' => ['class' => 'url', 'style' => 'width: 15%;'],
                ],
                [
                    'attribute' => 'iso',
                    'headerOptions' => ['class' => 'iso'],
                    'filterOptions' => ['class' => 'iso'],
                    'contentOptions' => ['class' => 'iso', 'style' => 'width: 15%;'],
                ],
                [
                    'attribute' => 'store_id',
                    'headerOptions' => ['class' => 'store_id'],
                    'filterOptions' => ['class' => 'store_id'],
                    'contentOptions' => ['class' => 'store_id', 'style' => 'width: 15%;'],
                ],
                [
                    'attribute' => 'active',
                    'filter' => StoreSearch::getActive(),
                    'content' => function($data) {
                        return StoreSearch::getActiveText($data->active);
                    },
                    'headerOptions' => ['class' => 'active'],
                    'filterOptions' => ['class' => 'active'],
                    'contentOptions' => ['class' => 'active', 'style' => 'width: 15%;'],
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
