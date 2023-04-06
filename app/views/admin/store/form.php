<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\entities\admin\Store;

$this->title = Yii::t('admin', 'Магазины') . ' - ' . $model->title;

?>

<div class="page">
    <div class="container">
        <h1 class="mb-4"><?= Html::a('<i class="fas fa-arrow-circle-left"></i>', ['/admin/store/index']) ?></h1>

        <?php $form = ActiveForm::begin([
            'validateOnBlur' => false,
            'options' => ['class' => 'form'],
        ]); ?>
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'id')
                        ->textInput(['placeholder' => Html::encode($model->getAttributeLabel('id'))]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'title')
                        ->textInput(['placeholder' => Html::encode($model->getAttributeLabel('title'))]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'type')
                        ->dropDownList(Store::getTypeList(), ['prompt' => Yii::t('app', 'Select...')]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'currency_iso')
                        ->textInput(['placeholder' => Html::encode($model->getAttributeLabel('currency_iso')), 'minlength' => 3, 'maxlength' => 3]) ?>
                </div>
            </div>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('admin', 'Сохранить'), ['class' => 'btn btn-success']) ?>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
