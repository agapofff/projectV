<?php

use yii\helpers\Html;

?>

<section class="main-products">
    <div class="container">
        <h2 class="main-products__title fz2">
            <?= $category === 'nutraceuticals' ? Yii::t('app', 'Нутрицевтики') : Yii::t('app', 'Космецевтика') ?>
        </h2>
        <div class="main-products__list row">
        <?php foreach ($products as $key => $product) { ?>
            <div class="main-products__item col-xl-4 col-md-6">
                <?= $this->renderFile('@app/views/store/default/_catalog-list.php', [
                    'index' => ++$key,
                    'model' => $product,
                ]) ?>
            </div>
        <?php } ?>
        </div>
        <div class="main-products__btn-row">
            <?= Html::a(Yii::t('app', 'Каталог'), ['/store/default/catalog', 'category' => $category], ['class' => 'main-products__btn btn btn_empty']) ?>
        </div>
    </div>
</section>
