<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\forms\auth\ResetPasswordRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('admin', 'Сбросить пароль');
?>

<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 col-sm-6 offset-sm-3">
                <h2 class="mb-4"><?= Html::encode($this->title) ?></h2>

                <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

                <?= $form->field($model, 'username')
                    ->label(false)
                    ->textInput(['autofocus' => true, 'maxlength' => 100, 'placeholder' => Html::encode($model->getAttributeLabel('username'))]) ?>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('admin', 'Отправить'), ['class' => 'btn btn-primary']) ?>
                    <?= Html::a(Yii::t('admin', 'Войти'), ['/auth/auth/login'], ['class' => 'float-right']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
