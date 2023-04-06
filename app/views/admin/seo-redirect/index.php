<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;
use yii\grid\GridView;
use app\forms\admin\SeoRedirectSearch;

$this->title = Yii::t('admin', 'SEO: редиректы');

?>

<?php Pjax::begin(['scrollTo' => 0, 'timeout' => 10000, 'options' => ['id' => 'page-seo-redirect', 'class' => 'page']]) ?>
    <div class="container">

        <?= Html::a(Yii::t('admin', 'Очистить фильтр'), ['/admin/seo-redirect/index'], ['class' => 'btn btn-dark']) ?>
        <?= Html::a(Yii::t('admin', 'Добавить редирект'), ['/admin/seo-redirect/create'], ['class' => 'btn btn-success float-right']) ?>

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
                    'attribute' => 'id',
                    'content' => function($data) {
                        return '<span class="badge badge-dark">' . $data->id . '</span>';
                    },
                    'headerOptions' => ['class' => 'id'],
                    'filterOptions' => ['class' => 'id'],
                    'contentOptions' => ['class' => 'id text-center', 'style' => 'width: 10%;'],
                ],
                [
                    'attribute' => 'type',
                    'filter' => SeoRedirectSearch::getTypeList(),
                    'content' => function($data) {
                        $checked = $data->type === 1 ? ' checked' : '';
                        return '
                        <div class="custom-control custom-checkbox" style="margin: 3px 0;">
                            <input type="checkbox" class="custom-control-input type-input" id="type-' . $data->id . '"' . $checked . ' />
                            <label class="custom-control-label" for="type-' . $data->id . '">/rt/</label>
                        </div>
                        ';
                    },
                    'headerOptions' => ['class' => 'type'],
                    'filterOptions' => ['class' => 'type'],
                    'contentOptions' => ['class' => 'type', 'style' => 'width: 10%;'],
                    'encodeLabel' => false,
                ],
                [
                    'attribute' => 'url_from',
                    'content' => function($data) {
                        return '
                        <div class="input-group">
                            <input type="text" value="' . $data->url_from . '" class="form-control url_from-input" placeholder="" required="" />
                        </div>
                        ';
                    },
                    'headerOptions' => ['class' => 'url_from'],
                    'filterOptions' => ['class' => 'url_from'],
                    'contentOptions' => ['class' => 'url_from', 'style' => 'width: 35%;'],
                    'encodeLabel' => false,
                ],
                [
                    'attribute' => 'url_to',
                    'content' => function($data) {
                        return '
                        <input type="text" value="' . $data->url_to . '" class="form-control url_to-input" placeholder="" required="" />
                        ';
                    },
                    'headerOptions' => ['class' => 'url_to'],
                    'filterOptions' => ['class' => 'url_to'],
                    'contentOptions' => ['class' => 'url_to', 'style' => 'width: 35%;'],
                    'encodeLabel' => false,
                ],
                [
                    'content' => function($data) {
                        return '<i class="delete__icon fas fa-trash-alt" data-id="' . $data->id . '"></i>';
                    },
                    'headerOptions' => ['class' => 'delete'],
                    'filterOptions' => ['class' => 'delete'],
                    'contentOptions' => ['class' => 'delete text-center text-dark', 'style' => 'width: 10%;'],
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

<?php

$urlUpdate = Url::to(['/admin/seo-redirect/update']);
$urlDelete = Url::to(['/admin/seo-redirect/delete']);

$js = <<<JS
$(document).on('change', 'input', function() {
    var elRow = $(this).parents('tr'),
        id = elRow.data('key'),
        type = elRow.find('.type-input').is(':checked') ? 1 : 0,
        url_from = elRow.find('.url_from-input').val(),
        url_to = elRow.find('.url_to-input').val();

    console.log(id, type, url_from, url_to);

    $.ajax({
        url: '$urlUpdate',
        type: 'POST',
        dataType: 'json',
        data: {
            id: id,
            type: type,
            url_from: url_from,
            url_to: url_to
        },
    });
});

$(document).on('click', '.delete__icon', function() {
    var id = $(this).data('id');
    $(this).html('...');
    $.ajax({
        url: '$urlDelete',
        type: 'POST',
        dataType: 'json',
        data: {
            id: id
        },
        success: function(data) {
            $.pjax.reload('#page-seo-redirect');
        },
    });
});
JS;
$this->registerJs($js, View::POS_READY);
