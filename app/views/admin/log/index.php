<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\grid\GridView;
use app\entities\admin\Log;
use yii\web\View;

$this->title = Yii::t('admin', 'Логирование');

?>

<?php Pjax::begin(['scrollTo' => 0, 'timeout' => 10000, 'options' => ['id' => 'page-countries', 'class' => 'page']]) ?>
<div class="container">
    <?= Html::a(Yii::t('admin', 'Очистить фильтр'), ['/admin/log/index'], ['class' => 'btn btn-dark']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $logModel,
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
                'headerOptions' => ['class' => 'id'],
                'filterOptions' => ['class' => 'id'],
                'contentOptions' => ['class' => 'id', 'style' => 'width: 10%; line-height: 31px;'],
            ],
            [
                'attribute' => 'type',
                'filter' => Log::getTypeList(),
                'content' => function($data) {
                    return '<div style="margin: 5px 0;">' . $data->getType() . '</div>';
                },
                'headerOptions' => ['class' => 'type'],
                'filterOptions' => ['class' => 'type'],
                'contentOptions' => ['class' => 'type', 'style' => 'width: 15%; line-height: 21px;'],
            ],
            [
                'attribute' => 'request',
                'content' => function($data) {
                    $request = json_decode($data->request);
                    $response = json_decode($data->getResponse());
                    $responseId = isset($response->id) ? $response->id : '';
                    if ($data->type === 'order') {
                        $content = $this->renderFile('@app/views/admin/log/_view-order.php', [
                            'request' => $request,
                        ]);
                    } else {
                        $content = $this->renderFile('@app/views/admin/log/_view-light-order.php', [
                            'request' => $request,
                        ]);
                    }

                    return '
                    <div class="log-content">
                        <button type="button" class="btn btn-sm btn-block btn-dark log-content__btn text-left px-3" data-toggle="collapse" data-target="#country-' . $data->id . '" aria-expanded="true" aria-controls="country-' . $data->id . '">
                            <i class="far fa-calendar-alt"></i> ' . Yii::$app->formatter->asDate($data->created_at, 'long') . ' &nbsp;
                            <i class="far fa-clock"></i> ' . Yii::$app->formatter->asTime($data->created_at, 'short') . '
                            <div class="float-right">
                                <i class="fas fa-hashtag"></i> ' . $responseId . '
                            </div>
                        </button>
                        <div class="collapse log-content__text" id="country-' . $data->id . '">
                            <div class="card box-shadow px-3">
                                ' . $content . '
                                <div class="my-2">
                                    ' . Html::a(Yii::t('admin', 'Открыть в CRM') . ' &nbsp;<small><i class="fas fa-external-link-alt"></i></small>', 'https://crm.sessia.com/shop/orders/edit/' . $responseId, [
                                        'class' => 'btn btn-primary',
                                        'target' => '_blank',
                                        'style' => 'text-decoration: none',
                                    ]) . '
                                </div>
                            </div>
                        </div>
                    </div>
                    ';
                },
                'headerOptions' => ['class' => 'request'],
                'filterOptions' => ['class' => 'request'],
                'contentOptions' => ['class' => 'request', 'style' => 'width: 60%;'],
            ],
            [
                'attribute' => 'status',
                'filter' => Log::getStatusList(),
                'content' => function($data) {
                    $checked = $data->status === 0 ? '' : ' checked';
                    return '
                    <div class="custom-control custom-checkbox" style="margin: 3px 0;" data-id="' . $data->id . '">
                        <input type="checkbox" class="custom-control-input" id="customCheck' . $data->id . '"' . $checked . ' />
                        <label class="custom-control-label" for="customCheck' . $data->id . '">' . Yii::t('admin', 'Обработан') . '</label>
                    </div>
                    ';
                },
                'headerOptions' => ['class' => 'status'],
                'filterOptions' => ['class' => 'status'],
                'contentOptions' => ['class' => 'status', 'style' => 'width: 15%; line-height: 25px;'],
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

<style>
.log-content {
}
.log-content__btn {
    cursor: pointer;
}
.log-content__text {
    display: none;
}
.log-content__text .card {
    padding: 1px 0;
}
.log-content .media .rounded {
    background-size: cover;
    background-position: center center;
}
.log-content .row {
    font-size: 14px;
    line-height: 22px;
}
.log-content .row > div {
    background-color: #f8f9fa;
    border-right: 1px solid #fff;
    border-bottom: 1px solid #fff;
}
</style>

<?php

$urlChangeStatus = Url::to(['/admin/log/change-status']);

$js = <<<JS
$(document).on('click', '.custom-control-label', function(event) {
    event.stopImmediatePropagation();

    var elCheckbox = $(this).parents('.custom-checkbox'),
        id = elCheckbox.data('id'),
        status = elCheckbox.find('.custom-control-input').is(':checked') ? 0 : 1;

    $.ajax({
        url: '$urlChangeStatus',
        type: 'POST',
        data: {
            id: id,
            status: status
        }
    });
});
JS;
$this->registerJs($js, View::POS_READY);