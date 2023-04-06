<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use yii\web\View;

/* @var $model app\entities\about\Post */

$this->title = Yii::t('app', 'Редактирование') . ' - ' . $model->title;

?>

<style>
    .redactor-box {
        margin: 0;
        border: 1px solid #ced4da;
        border-radius: .25rem;
        overflow: hidden;
    }
    .redactor-toolbar {
        box-shadow: none;
        border-bottom: 1px solid #ced4da;
    }
    .redactor-editor {
        border: none;
        padding: .375rem .75rem;
        font-size: 1rem;
        line-height: 1.5;
        font-family: "PT Sans", Arial, sans-serif;
        color: #495057;
    }
    .redactor-placeholder:after {
        top: .375rem;
        left: .75rem;
        font-size: 1rem;
        line-height: 1.5;
        font-family: "PT Sans", Arial, sans-serif;
        color: #495057 !important;
        opacity: .9;
    }
</style>

<section class="section page">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-md-12">
                <h1 class="mb-5">
                    <?= Html::a('<i class="fas fa-arrow-circle-left"></i>', $post->getUrl()) ?>
                </h1>
                <?php $form = ActiveForm::begin([
                    'id' => 'news-form',
                    'validateOnBlur' => false,
                    'options' => ['class' => 'form', 'enctype' => 'multipart/form-data'],
                ]); ?>
                    <?= $form->field($model, 'type')
                        ->label(false)
                        ->hiddenInput() ?>

                    <?= $form->field($model, 'metadata_title')
                        ->textArea(['placeholder' => Html::encode($model->getAttributeLabel('metadata_title'))]) ?>

                    <?= $form->field($model, 'metadata_description')
                        ->textArea(['placeholder' => Html::encode($model->getAttributeLabel('metadata_description'))]) ?>

                    <?= $form->field($model, 'title')
                        ->textArea(['placeholder' => Html::encode($model->getAttributeLabel('title'))]) ?>

                    <?= $form->field($model, 'announcement')
                        ->textArea(['placeholder' => Html::encode($model->getAttributeLabel('announcement'))]) ?>

                    <?= $form->field($model, 'text', ['options' => ['class' => 'mb-3']])
                        ->widget(Widget::class, [
                            'settings' => [
                                'placeholder' => Html::encode($model->getAttributeLabel('text')),
                                'lang' => 'ru',
                                'pastePlainText' => true,
                                'buttonSource' => true,
                                'uploadOnlyImage' => true,
                                'minHeight' => 200,
                                'imageUpload' => Url::to(['/about/post/image-upload', 'id' => $model->id]),
                                'imageManagerJson' => Url::to(['/about/post/images-get', 'id' => $model->id]),
                                'imageDelete' => Url::to(['/about/post/image-delete', 'id' => $model->id]),
                                'plugins' => [
                                    'alignment',
                                    'video',
                                    'inlinestyle',
                                    'fullscreen',
                                    'table',
                                ],
                            ],
                            'plugins' => [
                                'imagemanager' => 'vova07\imperavi\bundles\ImageManagerAsset',
                            ],
                        ]
                    ) ?>

                    <?php foreach (['cover', 'img'] as $img) { ?>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="bg-dark h-100 rounded">
                                <?php if ($post->$img !== '') { ?>
                                    <?php $getUrlImg = $img === 'cover' ? $post->getUrlCover() : $post->getUrlImg(); ?>
                                    <?= Html::img($getUrlImg, ['class' => 'img-fluid']) ?>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div><?= Html::encode($model->getAttributeLabel($img)) ?></div>
                            <div class="figure-caption mb-3">
                                <?= Yii::t('app', 'Ширина: {width}px, высота: {height}px', [
                                    'width' => Yii::$app->params['images']['post'][$img][0],
                                    'height' => Yii::$app->params['images']['post'][$img][1],
                                ]) ?>
                            </div>
                            <?= $form->field($model, $img, ['options' => ['class' => 'form-group select-img']])
                                ->label(false)
                                ->fileInput() ?>
                        </div>
                    </div>
                    <?php } ?>

                    <?= $form->field($model, 'created_at')
                        ->textInput(['type' => 'datetime-local']) ?>

                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-lg btn-primary']) ?>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</section>

<?php
$js = "autosize($('textarea'));";
$this->registerJs($js, View::POS_READY);
