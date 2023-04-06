<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \app\forms\auth\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Подтверждение сброса пароля');
?>

<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 col-sm-6 offset-sm-3">
                <h2 class="mb-4"><?= Html::encode($this->title) ?></h2>

                <?php if (Yii::$app->getSession()->hasFlash('success')) { ?>
                    <?= Yii::$app->getSession()->getFlash('success') ?>
                <?php } else { ?>
    
                <?php if (Yii::$app->getSession()->hasFlash('error')) { ?>
                    <?= Yii::$app->getSession()->getFlash('error') ?>
                    <br><br>
                <?php } ?>

                <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

                <?= $form->field($model, 'password')
                    ->label(false)
                    ->passwordInput(['autofocus' => true, 'placeholder' => Html::encode($model->getAttributeLabel('password'))]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>

                <?php } ?>
            </div>
        </div>
    </div>
</div>
