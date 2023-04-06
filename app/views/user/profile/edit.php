<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;

$this->title = Yii::t('admin', 'Настройки');
?>

<section class="section page">
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 col-sm-6 offset-sm-3">
                <h2 class="mb-4"><?= Html::encode($this->title) ?></h2>

                <?php $form = ActiveForm::begin([
                    'id' => 'user-form',
                    'validateOnBlur' => false,
                    'enableClientValidation' => false,
                    'options' => ['class' => 'form'],
                ]); ?>

                <?= $form->field($model, 'username')
                    ->label(false)
                    ->textInput(['autofocus' => true, 'placeholder' => Html::encode($model->getAttributeLabel('username'))]) ?>
                <?= $form->field($model, 'password')
                    ->label(false)
                    ->passwordInput(['placeholder' => Html::encode($model->getAttributeLabel('password'))]) ?>

                <div class="help-hidden">
                    <?= $form->field($model, 'newPassword')
                        ->label(false)
                        ->passwordInput(['placeholder' => Html::encode($model->getAttributeLabel('newPassword'))]) ?>
                    <?= $form->field($model, 'newPassword_repeat')
                        ->label(false)
                        ->passwordInput(['placeholder' => Html::encode($model->getAttributeLabel('newPassword_repeat'))]) ?>
                </div>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('admin', 'Сохранить'), ['class' => 'btn btn-primary']) ?>
                    <div class="change-password float-right"><?= Yii::t('admin', 'Изменить пароль') ?></div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</section>

<?php
$js = "
$(document).on('click', '.change-password', function(){
    $(this).remove();
    $('.help-hidden').show().css('display', 'block !important');
    return false;
});

function checkError() {
    if($('.help-hidden').find('.form-group').is('.has-error')) {
        $('.change-password').click();
    }
}
checkError();
";
$this->registerJs($js, View::POS_READY);
