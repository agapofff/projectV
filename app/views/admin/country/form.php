<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use app\entities\lang\Lang;

$this->title = Yii::t('admin', 'Страны') . ' - ' . $country->getLocalTitle();

?>

<div class="page">
    <div class="container">
        <h1 class="mb-5"><?= Html::a('<i class="fas fa-arrow-circle-left"></i>', ['/admin/country/index']) ?></h1>

        <?php $form = ActiveForm::begin([
            'validateOnBlur' => false,
            'options' => ['class' => 'form'],
        ]); ?>
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($formCountry, 'title')
                        ->textarea(['placeholder' => Html::encode($formCountry->getAttributeLabel('title')), 'rows' => 16]) ?>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-8">
                            <?= $form->field($formCountry, 'domain')
                                ->textInput(['placeholder' => Html::encode($formCountry->getAttributeLabel('domain'))]) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($formCountry, 'iso')
                                ->textInput(['placeholder' => Html::encode($formCountry->getAttributeLabel('currency_iso')), 'minlength' => 2, 'maxlength' => 3]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <?= $form->field($formCountry, 'lang_id')
                                ->dropDownList(ArrayHelper::map(Lang::find()->select('id, name, iso, url')->orderBy('iso')->all(), 'id', 'fullName'), ['prompt' => Yii::t('admin', 'Select...')]) ?>
                        </div>
                        <div class="col-md-8">
                            <?= $form->field($formCountry, 'languages')
                                ->textInput() ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <?= $form->field($formCountry, 'store_id')
                                ->dropDownList(ArrayHelper::map($country->getStores(), 'id', 'id'), ['prompt' => Yii::t('admin', 'Select...')]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <?= $form->field($formCountry, 'phone_code')
                                ->textInput(['placeholder' => Html::encode($formCountry->getAttributeLabel('currency_iso')), 'minlength' => 2, 'maxlength' => 4]) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($formCountry, 'phone_mask')
                                ->textInput(['placeholder' => Html::encode($formCountry->getAttributeLabel('currency_iso')), 'minlength' => 5, 'maxlength' => 25]) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($formCountry, 'post_code')
                                ->textInput(['placeholder' => Html::encode($formCountry->getAttributeLabel('post_code'))]) ?>
                        </div>
                    </div>
                </div>
            </div>

            <?= Html::submitButton(Yii::t('admin', 'Сохранить'), ['class' => 'btn btn-primary btn-lg mt-2']) ?>
        <?php ActiveForm::end(); ?>

    </div>
</div>

<?= $this->renderFile('@app/views/admin/_js__admin.php', [
    'url' => 'admin/lang-in-country',
    'sortable' => true,
    'delete' => true,
]) ?>
