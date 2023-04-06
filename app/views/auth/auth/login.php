<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Yii::t('admin', 'Войти');

?>

<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 col-sm-6 offset-sm-3">
                <h2 class="mb-4"><?= Html::encode($this->title) ?></h2>

                <?php if (Yii::$app->getSession()->hasFlash('error')) { ?>
                    <?= Yii::$app->getSession()->getFlash('error') ?>
                    <br><br>
                <?php } ?>

                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'validateOnBlur' => false,
                    'options' => ['class' => 'form'],
                ]); ?>

                <?= $form->field($model, 'username')
                    ->label(false)
                    ->textInput(['autofocus' => true, 'maxlength' => 100, 'placeholder' => Html::encode($model->getAttributeLabel('username'))]) ?>
                <?= $form->field($model, 'password')
                    ->label(false)
                    ->passwordInput(['maxlength' => 150, 'placeholder' => Html::encode($model->getAttributeLabel('password'))]) ?>

                <div class="form-group">
                    <?= Html::submitButton($this->title, ['class' => 'btn btn-primary']) ?>
                    <?= Html::a(Yii::t('admin', 'Я зыбыл пароль'), ['/auth/reset/request'], ['class' => 'float-right']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
