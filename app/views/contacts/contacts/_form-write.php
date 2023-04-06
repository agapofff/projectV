<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;

?>

<div class="popup" data-key="popup-form-write">
    <div class="popup__inner">
        <div class="popup__close popup-close"></div>

        <div class="popup__content">
            <div class="popup__title fz3"><?= Yii::t('app', 'Напишите нам') ?></div>

            <?php $form = ActiveForm::begin([
                'id' => 'form-write',
                'validateOnBlur' => false,
                'enableClientValidation' => false,
                'options' => ['class' => 'form popup__form'],
            ]); ?>

                <div class="popup__form-values">
                    <?= $form->field($model, 'name')
                        ->textInput(['placeholder' => Html::encode($model->getAttributeLabel('name'))]) ?>

                    <?= $form->field($model, 'email')
                        ->textInput(['placeholder' => Html::encode($model->getAttributeLabel('email'))]) ?>

                    <?= $form->field($model, 'text', ['options' => ['class' => 'form-group form-group_full']])
                        ->label(false)
                        ->textArea(['rows' => 6]) ?>
                </div>

                <?= Html::submitButton(Yii::t('app', 'Отправить'), ['class' => 'btn btn_empty popup__form-btn']) ?>

             <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<?php

$url = Url::to(['/contacts/contacts/write']);

$script = <<<JS

var formWrite = $('#form-write');
formWrite.on('click', '.btn', function() {
    var data = formWrite.serialize();
    $.ajax({
        url: '$url',
        type: 'POST',
        data: data,
        dataType : 'json',
        beforeSend: function() {
            formWrite.addClass('popup__form_waiting');
        },
        success: function(response) {
            formWrite.removeClass('popup__form_waiting')
                     .find('.form-group').removeClass('form-group_error')
                     .find('.help-block').removeClass('help-block_error').empty();
            if (response.status === 'success') {
                $('.popup__content').html(response.html);
            } else {
                $.each(response, function(key, val) {
                    formWrite.find('.field-' + key).addClass('form-group_error')
                             .find('.help-block').addClass('help-block_error').html('<div class="help-block__message">' + val + '</div>');
                });
            }
        }
    });
    return false;
});

JS;
$this->registerJs($script, View::POS_READY);
