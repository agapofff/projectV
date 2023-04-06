<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\forms\admin\ProductSearch;
use yii\widgets\Pjax;

$this->title = Yii::t('app', 'Продукция') . ' - ' . $model->sessia_title;

?>

<div class="page">
    <div class="container">
        <h1 class="mb-5"><?= Html::a('<i class="fas fa-arrow-circle-left"></i>', ['/admin/product/index']) ?></h1>

        <div class="bg-white rounded box-shadow overflow-hidden">
            <div class="row p-4">
                <div class="col-12">
                    <h2 class="mb-4"><?= Yii::t('app', 'Основные параметры') ?></h2>
                </div>
                <div class="col-md-3">
                    <div class="bg-white rounded box-shadow mb-5">
                        <div class="card-img-top" style="background: url('<?= $model->sessia_img ?>') 50% 50% / contain no-repeat; padding-top: 50%;"></div>
                        <div class="card-body text-center"><?= $model->sessia_title ?></div>
                        <div class="card-body text-center"><?= $model->sessia_vendor_code ?></div>
                    </div>
                </div>
                <div class="col-md-9">
                    <?php $form = ActiveForm::begin([
                        'validateOnBlur' => false,
                        'options' => ['class' => 'form'],
                    ]); ?>
                    <div class="row">
                        <div class="col-lg-4">
                             <?= $form->field($model, 'category')
                                 ->dropDownList(ProductSearch::getCategoryList(), ['prompt' => '']) ?>
                             <?= $form->field($model, 'collection')
                                 ->dropDownList(ProductSearch::getCollectionList(), ['prompt' => '']) ?>
                             <?= $form->field($model, 'active')
                                 ->checkbox() ?>
                        </div>
                        <div class="col-lg-4">
                            <?= $form->field($model, 'sex')->dropDownList(ProductSearch::getSexList(true), [
                                'multiple' => 'multiple',
                                'size' => count(ProductSearch::getSexList(true)),
                            ]) ?>
                        </div>
                        <div class="col-lg-4">
                            <?= $form->field($model, 'problem')->dropDownList(ProductSearch::getProblemList(true), [
                                'multiple' => 'multiple',
                                'size' => count(ProductSearch::getProblemList(true)),
                            ]) ?>
                        </div>
                    </div>
                    <?php if (Yii::$app->user->can('admin')) { ?>
                    <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success']) ?>
                    <?php } ?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>


            <?php Pjax::begin(['scrollTo' => false, 'timeout' => 10000, 'options' => ['id' => 'currencies', 'class' => 'currencies border-top']]) ?>

            <h2 class="mt-4 ml-4"><?= Yii::t('app', 'Изображения') ?></h2>

            <?= $this->renderFile('@app/views/admin/product-img/_form.php', [
                'productImgs' => $productImgs,
                'model' => $formProductImg,
                'productTranslate' => $productTranslate,
                'currencies' => $currencies,
            ]) ?>

            <?php Pjax::end() ?>


            <?php Pjax::begin(['scrollTo' => false, 'timeout' => 10000, 'options' => ['id' => 'langs', 'class' => 'langs border-top border-3']]) ?>

            <h2 class="mt-4 ml-4"><?= Yii::t('app', 'Описание') ?></h2>

            <?= $this->renderFile('@app/views/admin/product-translate/_menu-langs.php', [
                'id' => $model->id,
                'currencyIso' => $currencyIso,
                'langs' => $langs,
                'lang' => $lang,
                'langDefault' => $langDefault,
            ]) ?>

            <?= $this->renderFile('@app/views/admin/product-translate/_form.php', [
                'product' => $product,
                'model' => $modelProductTranslate,
                'productTranslateDefault' => $productTranslateDefault,
                'langs' => $langs,
            ]) ?>
    
            <?php Pjax::end() ?>

            <div class="px-4">
                <hr class="my-0">
            </div>

            <div>
                <h2 class="mt-4 ml-4"><?= Yii::t('app', 'Документы') ?></h2>
                <?= $this->renderFile('@app/views/admin/product-doc/_form.php', [
                    'productDocsDefault' => $productDocsDefault,
                    'productDocs' => $productDocs,
                    'model' => $formProductDoc,
                    'productTranslate' => $productTranslate,
                ]) ?>
            </div>

        </div>

        <?php if (Yii::$app->user->can('admin')) { ?>
        <div class="bg-white rounded box-shadow overflow-hidden mt-4">
            <?= $this->renderFile('@app/views/admin/product-sessia/_list.php', [
                'sessias' => $product->sessias,
            ]) ?>
            <?= $this->renderFile('@app/views/admin/product-sessia/_form.php', [
                'current_id' => $product->id,
                'products' => $products,
            ]) ?>
        </div>
        <?php } ?>

    </div>
</div>

<style>
    .nav-item.active a {font-weight: bold;}
</style>
