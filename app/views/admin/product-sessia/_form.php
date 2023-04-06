<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

?>

<div class="p-4 border-top">
    <?php $form = ActiveForm::begin([
        'action' => ['/admin/product/combine', 'current_id' => $current_id],
        'method' => 'get',
        'validateOnBlur' => false,
        'options' => [
            'class' => 'form',
        ],
    ]) ?>
    <div class="row">
        <div class="col-9">
            <?= Html::dropDownList(
                'id',
                '',
                ArrayHelper::map($products, 'id', 'title'),
                ['prompt' => Yii::t('admin', 'Этот дублирующий товар объеденить с главным товаром...'), 'class' => 'form-control']
            ) ?>
        </div>
        <div class="col-3">
            <?= Html::submitButton('<i class="fas fa-long-arrow-alt-right"></i>', ['class' => 'btn btn-danger w-100']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
