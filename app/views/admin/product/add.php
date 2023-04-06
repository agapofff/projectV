<?php

use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Продукция') . ' - ' . Yii::t('app', 'Добавить');

?>

<div class="page">
    <div class="container">
        <?= Html::a(Yii::t('app', 'Продукция'), ['/admin/product/index'], ['class' => 'btn btn-dark']) ?>
        <?php $form = ActiveForm::begin([
            'action' => Url::to(['/admin/product-sessia/import-product/']),
            'method' => 'get',
            'validateOnBlur' => false,
            'options' => ['class' => 'form mt-4'],
        ]); ?>
        <div class="row">
            <div class="col-lg-3">
                <?= Html::textInput('product_id', null, ['class' => 'form-control', 'placeholder' => Yii::t('admin', 'ID товара в Sessia')]) ?>
            </div>
            <div class="col-lg-3">
                <?= Html::submitButton(Yii::t('app', 'Добавить'), ['class' => 'btn btn-success']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
