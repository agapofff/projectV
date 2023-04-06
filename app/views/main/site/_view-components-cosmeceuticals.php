<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

$arr = [
    (object) [
        'image' => '08.png',
        'name' => Yii::t('app', 'Медь'),
        'link' => false,
    ],
    (object) [
        'image' => '11.png',
        'name' => Yii::t('app', 'Цинк'),
        'link' => false,
    ],
    (object) [
        'image' => '07.png',
        'name' => Yii::t('app', 'Гриб агарик'),
        'link' => ['/main/component/view', 'id' => 20, 'url' => 'agaric-mushroom'],
    ],
    (object) [
        'image' => '03.png',
        'name' => Yii::t('app', 'Огурец'),
        'link' => ['/main/component/view', 'id' => 19, 'url' => 'cucumber'],
    ],
    (object) [
        'image' => '04.png',
        'name' => Yii::t('app', 'Гиалуроновая кислота'),
        'link' => ['/main/component/view', 'id' => 18, 'url' => 'hyalo-oligo'],
    ],
    (object) [
        'image' => '12.png',
        'name' => Yii::t('app', 'Сепитоник'),
        'link' => ['/main/component/view', 'id' => 16, 'url' => 'sepitonic'],
    ],
    (object) [
        'image' => '06.png',
        'name' => Yii::t('app', 'Гидролат нероли'),
        'link' => ['/main/component/view', 'id' => 22, 'url' => 'neroli-hydrolate'],
    ],
    (object) [
        'image' => '13.png',
        'name' => Yii::t('app', 'Эдельвейс'),
        'link' => ['/main/component/view', 'id' => 17, 'url' => 'edelweiss-extract'],
    ],
    (object) [
        'image' => '02.png',
        'name' => Yii::t('app', 'Железо'),
        'link' => false,
    ],
    (object) [
        'image' => '05.png',
        'name' => Yii::t('app', 'Магний'),
        'link' => false,
    ],
    (object) [
        'image' => '09.png',
        'name' => Yii::t('app', 'Лаванда'),
        'link' => ['/main/component/view', 'id' => 21, 'url' => 'living-water'],
    ],
    (object) [
        'image' => '10.png',
        'name' => Yii::t('app', 'Масло Ши'),
        'link' => false,
    ],
    (object) [
        'image' => null,
        'name' => null,
        'link' => false,
    ],
    (object) [
        'image' => '01.png',
        'name' => Yii::t('app', 'Швейцарская вода'),
        'link' => ['/main/component/view', 'id' => 15, 'url' => 'swiss-glacial-water'],
    ],
];

?>

<section class="main-components">
    <div class="container">
        <h2 class="main-components__title fz2">
            <?= Yii::t('app', 'Активные компоненты') ?>
        </h2>
    </div>
    <div id="marquee" class="main-components__list">
        <?php for ($k = 1; $k <= 2; $k++) { ?>
        <div class="main-components__list-inner main-components__list-inner_<?= $k ?> str_wrap">
            <?php foreach ($arr as $key => $val) { ?>
                <?php if (($key + 2 + $k) % 2 !== 0) { ?>
                <?php if (!empty($val->image)) { ?>
                    <<?= $val->link ? 'a href="' . Url::to($val->link) . '"' : 'div' ?> class="main-components__item not-vitamin">
                    <div class="main-components__image">
                        <?= Html::img('@web/storage/components-cosmetic/' . $val->image . '?v=1', ['class' => 'main-components__picture' . ($val->link ? ' active' : '')]) ?>
                    </div>
                    <div class="main-components__name">
                        <?= $val->name ?>
                    </div>
                    </<?= $val->link ? 'a' : 'div' ?>>
                <?php } ?>
            <?php } ?>
        <?php } ?>
        </div>
    <?php } ?>
    </div>
</section>

<?php

$js = <<< JS

$('.main-components__list-inner_1').liMarquee({
    circular: true,
    startShow: true
});

$('.main-components__list-inner_2').liMarquee({
    circular: true,
    startShow: true,
    direction: 'right'
});

$('.main-components__item_vitamin').mouseenter(function() {
    $(this).parents('.main-components__list-inner').addClass('active');
    $(this).parents('.simplemarquee-wrapper').addClass('active');
    $(this).parents('.main-components__item').addClass('active');
    $(this).find('.main-components__image').addClass('active');
    $(this).find('.main-components__component').addClass('active');
}).mouseleave(function() {
    $(this).parents('.main-components__list-inner').removeClass('active');
    $(this).parents('.simplemarquee-wrapper').removeClass('active');
    $(this).parents('.main-components__item').removeClass('active');
    $(this).find('.main-components__image').removeClass('active');
    $(this).find('.main-components__component').removeClass('active');
});

JS;
$this->registerJs($js, View::POS_READY);
