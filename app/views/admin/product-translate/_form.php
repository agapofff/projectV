<?php

use app\entities\admin\ProductTranslate;
use yii\helpers\Html;
use yii\web\View;
use yii\bootstrap\ActiveForm;

$arr = [
    'title' => '',
    'description' => '',
    'properties' => '',
    'benefits' => '',
    'video' => '',
    'main_components' => '',
    'composition' => '{' . Yii::t('app', 'Вещество') . '} - {' . Yii::t('app', 'Количество') . '}',
    'recommendations' => '',
    'dosage' => '',
    'issue' => '',
    'storage' => '',
];

?>

<?php $form = ActiveForm::begin([
    'validateOnBlur' => false,
    'options' => ['class' => 'form p-4'],
]); ?>
    <?php foreach ($arr as $key => $val) { ?>
    <div class="row mb-3">
        <div class="col-6">
            <?= Html::encode($model->getAttributeLabel($key)) ?>
            <div class="mt-2 form-control bg-light">
            <?php if (isset($productTranslateDefault->$key)) { ?>
                <?= nl2br($productTranslateDefault->$key) ?>
            <?php } ?>
            </div>
        </div>
        <div class="col-6">
            <?= $form->field($model, $key)
                ->textArea() ?>
            <?php if (!empty($val)) { ?>
            <div class="text-secondary small mb-3" style="margin-top: -.5rem;">
                <?= $val ?>
            </div>
            <?php } ?>
        </div>
    </div>
    <?php } ?>

    <div class="row">
        <div class="col-6 offset-6">
        <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success']) ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>

<div class="form p-4">
    <table>
        <tr>
        <?php foreach ($langs as $lang) { ?>
            <td class="p-1 border" style="width: <?= (100 / count($langs)) ?>%;"><?= $lang->iso ?></td>
        <?php } ?>
        </tr>
        <?php foreach ($arr as $key => $val) { ?>
        <tr>
            <td colspan="<?= count($langs) ?>" class="bg-secondary text-white p-1 border border-secondary"><?= $key ?></td>
        </tr>
        <tr>
        <?php foreach ($langs as $lang) { ?>
            <?php $translate = ProductTranslate::find()
                ->where('product_id = :product_id AND lang_id = :lang_id', [
                    'product_id' => $product->id,
                    'lang_id' => $lang->id,
                ])
                ->one(); ?>
            <td class="p-1 border" style="vertical-align: top;">
                <small>
                <?php if ($translate) { ?>
                    <?= !empty($translate->$key) ? nl2br($translate->$key) : '&nbsp;' ?>
                <?php } else { ?>
                    &nbsp;
                <?php } ?>
                </small>
            </td>
        <?php } ?>
        </tr>
        <?php } ?>
    </table>
</div>

<?php
$js = "autosize($('textarea'));";
$this->registerJs($js, View::POS_READY);
