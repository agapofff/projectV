<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\web\View;

?>

<div class="p-4">
    <?= $this->renderFile('@app/views/admin/_js__admin.php', [
        'url' => 'admin/product-img',
        'class' => 'imgs',
        'sortable' => true,
        'delete' => true,
        'axis' => '',
    ]) ?>
    <ul class="row list-group imgs">
    <?php foreach ($productImgs as $val) { ?>
        <li id="items[]_<?= $val->id ?>" class="col-lg-3 col-md-4 col-6 bg-dark list-group-item item-<?= $val->id ?>" data-id="<?= $val->id ?>">
            <div class="handle" style="background: url(<?= Url::to('@web' . $val->getUrl()) ?>) 50% 50% no-repeat;"></div>
            <?= Html::dropDownList('currency_iso', $val->currency_iso,
                ArrayHelper::map($currencies, 'iso', 'iso'),
                ['style' => 'position: absolute; top: 10px; left: 10px;', 'prompt' => '', 'data-id' => $val->id]) ?>
            <i class="fas fa-trash-alt text-danger delete" data-id="<?= $val->id ?>"></i>
        </li>
    <?php } ?>
    </ul>
    <style>
        .imgs.list-group { flex-direction: row; }
        .imgs .list-group-item { margin: 0 !important; padding: 10px; border-radius: 0 !important; }
        .imgs .handle { margin: 0 !important; padding-top: 75%; background-size: contain !important; }
        .imgs .delete {
            position: absolute;
            right: 10px;
            bottom: 10px;
            background-color: #fff;
            cursor: pointer;
            float: right;
            width: 24px;
            height: 24px;
            line-height: 24px;
            text-align: center;
            border-radius: 100%;
            font-size: 14px;
        }
    </style>
    <?php if (Yii::$app->user->can('admin')) { ?>
    <?php $form = ActiveForm::begin([
        'validateOnBlur' => false,
        'options' => ['class' => 'form', 'enctype' => 'multipart/form-data'],
    ]); ?>
    <?= $form->field($model, 'product_id')
        ->label(false)
        ->hiddenInput() ?>
    <?= $form->field($model, 'currency_iso')
        ->label(false)
        ->hiddenInput() ?>
    <div class="figure-caption mb-3">
        <?= Yii::t('app', 'Ширина до: {width}px, высота до: {height}px', [
            'width' => Yii::$app->params['images']['product']['img'][0],
            'height' => Yii::$app->params['images']['product']['img'][1],
        ]) ?>
    </div>
    <?= $form->field($model, 'img')
        ->label(false)
        ->fileInput() ?>
    <?= Html::submitButton(Yii::t('app', 'Загрузить'), ['class' => 'btn btn-success']) ?>
    <?php ActiveForm::end(); ?>
    <?php } ?>
</div>

<?php

$url = Url::to(['/admin/product-img/iso']);

$js = <<<JS
$(document).on('change', '.imgs select', function() {
    var id = $(this).data('id');
    var iso = $(this).val();

    $.ajax({
        url: '$url',
        type: 'post',
        data: {
            id: id,
            iso: iso
        },
    });
});
JS;

$this->registerJs($js, View::POS_READY);