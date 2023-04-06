<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

?>

<div class="p-4">
    <h5><?= Yii::t('app', 'Документы') ?></h5>
    <div class="row">
        <div class="col-6">
            <?php if ($productDocsDefault) { ?>
                <ul class="row list-group docs">
                    <?php foreach ($productDocsDefault as $val) { ?>
                        <li class="col-12 list-group-item px-3 py-0" style="height: 44px; line-height: 44px;">
                            <?= $val->title ?>
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
        </div>
        <div class="col-6">
            <?= $this->renderFile('@app/views/admin/_js__admin.php', [
                'url' => 'admin/product-doc',
                'class' => 'docs',
                'sortable' => true,
                'delete' => true,
                'axis' => 'y',
            ]) ?>
            <?php if ($productDocs) { ?>
                <ul class="row list-group docs">
                    <?php foreach ($productDocs as $val) { ?>
                        <li id="items[]_<?= $val->id ?>" class="col-12 list-group-item item-<?= $val->id ?>" data-id="<?= $val->id ?>">
                            <i class="fas fa-bars handle"></i>
                            <?= Html::a(
                                '<i class="fas fa-link"></i>',
                                Url::to('@web' . $val->getUrl()),
                                ['class' => 'link', 'data-pjax' => 0, 'target' => '_blank']
                            ) ?>
                            <input type="text" value="<?= $val->title ?>" data-id="<?= $val->id ?>" />
                            <i class="fas fa-trash-alt text-danger delete" data-id="<?= $val->id ?>"></i>
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
            <style>
                .docs .list-group-item { margin: 0 !important; padding: 10px 34px 10px 74px; border-radius: 0 !important; position: relative; }
                .docs .handle,
                .docs .link,
                .docs .delete { position: absolute; top: 50%; font-size: 14px; line-height: 24px; margin-top: -12px; }
                .docs .handle { left: 10px; }
                .docs .link { left: 40px; width: auto; }
                .docs .delete { right: 10px; cursor: pointer; }
                .docs .link i { margin: 0; }
                .docs input { width: 100%; height: 24px; line-height: 24px; }
            </style>
            <?php if (Yii::$app->user->can('admin')) { ?>
                <?php $form = ActiveForm::begin([
                    'validateOnBlur' => false,
                    'options' => ['class' => 'form', 'enctype' => 'multipart/form-data'],
                ]); ?>
                <?= $form->field($model, 'product_id')
                    ->label(false)
                    ->hiddenInput() ?>
                <?= $form->field($model, 'lang_id')
                    ->label(false)
                    ->hiddenInput() ?>
                <?= $form->field($model, 'doc')
                    ->label(false)
                    ->fileInput() ?>
                <?= Html::submitButton(Yii::t('app', 'Загрузить'), ['class' => 'btn btn-success']) ?>
                <?php ActiveForm::end(); ?>
            <?php } ?>
        </div>
    </div>
</div>

<?= $this->renderFile('@app/views/admin/product-doc/_js.php') ?>