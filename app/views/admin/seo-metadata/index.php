<?php

use app\forms\admin\SeoMetadataForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;
use yii\grid\GridView;

$this->title = Yii::t('admin', 'SEO: метаданные');

?>

<?php Pjax::begin(['scrollTo' => 0, 'timeout' => 10000, 'options' => ['id' => 'page-seo-metadata', 'class' => 'page']]) ?>
    <div class="container">

        <?= Html::a(Yii::t('admin', 'Очистить фильтр'), ['/admin/seo-metadata/index'], ['class' => 'btn btn-dark']) ?>
        <?= Html::a(Yii::t('admin', 'Добавить ссылку'), ['/admin/seo-metadata/create'], ['class' => 'btn btn-success float-right']) ?>

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
                    'content' => function($data) {
                        return Html::a($data->link, $data->link, ['target' => '_blank']);
                    },
                    'attribute' => 'link',
                    'headerOptions' => ['class' => 'link'],
                    'filterOptions' => ['class' => 'link'],
                    'contentOptions' => ['class' => 'link', 'style' => 'width: 20%; max-width: 250px; word-wrap: break-word;'],
                    'encodeLabel' => false,
                ],
                [
                    'attribute' => 'title',
                    'headerOptions' => ['class' => 'title'],
                    'filterOptions' => ['class' => 'title'],
                    'contentOptions' => ['class' => 'title', 'style' => 'width: 20%;'],
                    'encodeLabel' => false,
                ],
                [
                    'attribute' => 'description',
                    'headerOptions' => ['class' => 'description'],
                    'filterOptions' => ['class' => 'description'],
                    'contentOptions' => ['class' => 'description', 'style' => 'width: 30%;'],
                    'encodeLabel' => false,
                ],
                [
                    'attribute' => 'h1',
                    'headerOptions' => ['class' => 'h1_'],
                    'filterOptions' => ['class' => 'h1_'],
                    'contentOptions' => ['class' => 'h1_', 'style' => 'width: 20%;'],
                    'encodeLabel' => false,
                ],
                [
                    'content' => function($data) {
                        return '<i class="delete__icon fas fa-trash-alt" data-id="' . $data->id . '"></i>';
                    },
                    'headerOptions' => ['class' => 'delete'],
                    'filterOptions' => ['class' => 'delete'],
                    'contentOptions' => ['class' => 'delete text-center text-dark', 'style' => 'width: 5%;'],
                ],
                [
                    'content' => function($data, $index) {
                        $form = new SeoMetadataForm($data);
                        return '
                            <i class="fas fa-edit"></i>
                        </td>
                    </tr>
                    <tr data-key="' . $index . '" class="metadata">
                        <td colspan="7">
                            ' . Html::beginForm(['/admin/seo-metadata/update', 'id' => $data->id], 'post', ['class' => 'metadata__form']) . '
                                ' . Html::activeInput('text', $form, 'link',
                                    ['class' => 'metadata__input form-control', 'placeholder' => Html::encode($form->getAttributeLabel('link'))]) . '
                                <div class="row">
                                    <div class="col-md-8">
                                        ' . Html::activeInput('text', $form, 'title',
                                            ['class' => 'metadata__input form-control mt-3', 'placeholder' => Html::encode($form->getAttributeLabel('title'))]) . '
                                        ' . Html::activeTextarea($form, 'description',
                                            ['class' => 'metadata__input form-control mt-3', 'placeholder' => Html::encode($form->getAttributeLabel('description'))]) . '
                                        ' . Html::activeTextarea($form, 'text',
                                            ['class' => 'metadata__input form-control mt-3', 'placeholder' => Html::encode($form->getAttributeLabel('text'))]) . '
                                    </div>
                                    <div class="col-md-4">
                                        ' . Html::activeTextarea($form, 'h1',
                                            ['class' => 'metadata__input form-control mt-3', 'placeholder' => Html::encode($form->getAttributeLabel('h1'))]) . '
                                    </div>
                                </div>
                                ' . Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'metadata__btn btn btn-primary mt-3']) . '
                            ' . Html::endForm() . '
                        ';
                    },
                    'contentOptions' => ['class' => 'metadata-nav', 'style' => 'width: 5%;'],
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

$urlDelete = Url::to(['/admin/seo-metadata/delete']);

$js = <<<JS

class Metadata {

    constructor() {
        autosize($('textarea'));

        this.toggleForm();
        this.updateForm();
        this.deleteRow();
    }

    toggleForm() {
        var self = this;
        $(document).on('click', '.metadata-nav', function() {
            $(this).toggleClass('metadata-nav_active');
            var key = $(this).parents('tr').data('key');
            $('.metadata[data-key=' + key + ']').toggleClass('metadata_active');
            autosize($('textarea'));
        });
    }

    updateForm() {
        $(document).on('click', '.metadata__btn', function(e) {
            e.preventDefault();

            var form = $(this).parents('.metadata__form');

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                dataType: 'json',
                data: form.serialize(),
                beforeSend: function() {
                    form.css('opacity', .5);
                },
                success: function(data) {
                    $.pjax.reload('#page-seo-metadata');
                },
            });
        });
    }

    deleteRow() {
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
                    $.pjax.reload('#page-seo-metadata');
                },
            });
        });
    }
}

var metadata = new Metadata();

JS;
$this->registerJs($js, View::POS_READY);
