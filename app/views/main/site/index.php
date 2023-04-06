<?php

use yii\helpers\Url;
use yii\helpers\Html;

?>

<section class="main">
    <div class="main__list">
        <div class="main__item">
            <div class="main__content">
                <h1 class="main__title fz4"><?= Yii::t('app', 'Нутрицевтики') ?></h1>
                <?= Html::a(Yii::t('app', 'Перейти'), ['/main/site/view', 'category' => 'nutraceuticals'], ['class' => 'main__link btn btn_empty-invert']) ?>
            </div>
            <div class="main__bg" style="background-image: url('<?= Url::to('@web/storage/main/item-nutraceuticals.jpg?v=1') ?>')"></div>
        </div>
        <div class="main__item">
            <div class="main__content">
                <h1 class="main__title fz4"><?= Yii::t('app', 'Космецевтика') ?></h1>
                <?= Html::a(Yii::t('app', 'Перейти'), ['/main/site/view', 'category' => 'cosmeceuticals'], ['class' => 'main__link btn btn_empty-invert']) ?>
            </div>
            <div class="main__bg" style="background-image: url('<?= Url::to('@web/storage/main/item-cosmeceuticals.jpg?v=1') ?>')"></div>
        </div>
    </div>
</section>
