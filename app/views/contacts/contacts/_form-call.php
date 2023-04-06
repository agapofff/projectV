<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

?>

<div class="popup" data-key="popup-form-call">
    <div class="popup__inner">
        <div class="popup__close popup-close"></div>

        <div class="popup__content">
            <div class="popup__title fz3"><?= Yii::t('app', 'Перезвоните мне') ?></div>

            <?php $form = ActiveForm::begin([
                'id' => 'form-call',
                'validateOnBlur' => false,
                'enableClientValidation' => false,
                'options' => ['class' => 'form popup__form'],
            ]); ?>

                <div class="popup__form-values">
                    <?= $form->field($model, 'name')
                        ->textInput(['placeholder' => Html::encode($model->getAttributeLabel('name'))]) ?>

                    <?= $form->field($model, 'phone')
                        ->widget(MaskedInput::class, [
                            'mask' => $country->phone_code . ' ' . str_replace('_', '9', $country->phone_mask),
                            'options' => ['placeholder' => $country->phone_code . ' ' . $country->phone_mask],
                        ]) ?>
                </div>

                <?= Html::submitButton(Yii::t('app', 'Отправить'), ['class' => 'btn btn_empty popup__form-btn']) ?>

             <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<?php

$url = Url::to(['/contacts/contacts/call']);

$script = <<<JS

var formCall = $('#form-call');
formCall.on('click', '.btn', function() {
    var data = formCall.serialize();
    $.ajax({
        url: '$url',
        type: 'POST',
        data: data,
        dataType : 'json',
        beforeSend: function() {
            formCall.addClass('popup__form_waiting');
        },
        success: function(response) {
            formCall.removeClass('popup__form_waiting')
                    .find('.form-group').removeClass('form-group_error')
                    .find('.help-block').removeClass('help-block_error').empty();
            if (response.status === 'success') {
                $('.popup__content').html(response.html);
            } else {
                $.each(response, function(key, val) {
                    formCall.find('.field-' + key).addClass('form-group_error')
                            .find('.help-block').addClass('help-block_error').html('<div class="help-block__message">' + val + '</div>');
                });
            }
        }
    });
    return false;
});

JS;
$this->registerJs($script, View::POS_READY);
