<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\entities\admin\Store;

$this->title = Yii::t('admin', 'Языки') . ' - ' . $model->name;

?>

<div class="page">
    <div class="container">
        <h1 class="mb-5"><?= Html::a('<i class="fas fa-arrow-circle-left"></i>', ['/lang/default/index']) ?></h1>

        <?php $form = ActiveForm::begin([
            'validateOnBlur' => false,
            'options' => ['class' => 'form'],
        ]); ?>
            <div class="row mb-2">
                <div class="col-md-3">
                    <?= $form->field($model, 'id')
                        ->textInput(['placeholder' => Html::encode($model->getAttributeLabel('id'))]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'name')
                        ->textInput(['placeholder' => Html::encode($model->getAttributeLabel('title'))]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'url')
                        ->textInput(['placeholder' => Html::encode($model->getAttributeLabel('url')), 'minlength' => 2, 'maxlength' => 2]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'iso')
                        ->textInput(['placeholder' => Html::encode($model->getAttributeLabel('iso')), 'minlength' => 5, 'maxlength' => 10]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'store_id')
                        ->dropDownList(
                            ArrayHelper::map(
                                Store::find()
                                    ->select('id, type, title')
                                    ->orderBy('title')
                                    ->all(),
                                'id',
                                'idTypeTitle'
                            )
                        ) ?>
                </div>
            </div>

            <?= $form->field($model, 'active')->checkbox() ?>

            <?= Html::submitButton(Yii::t('admin', 'Сохранить'), ['class'=>'btn btn-primary btn-lg mt-2']) ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>
