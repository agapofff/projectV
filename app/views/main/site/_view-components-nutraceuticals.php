<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

$arr = [
    (object) [
        'image' => '01.png',
        'name' => Yii::t('app', 'Витамин Е'),
        'components' => ['01_01.png', '01_02.png', '01_03.png', '01_04.png', '01_05.png', '01_06.png'],
        'link' => false,
    ],
    (object) [
        'image' => '02.png',
        'name' => Yii::t('app', 'Экстракт элеутерококка'),
        'components' => [],
        'link' => ['/main/component/index', 'id' => 5],
    ],
    (object) [
        'image' => '03.png',
        'name' => Yii::t('app', 'Мелисcа'),
        'components' => [],
        'link' => ['/main/component/index', 'id' => 4],
    ],

    (object) [
        'image' => '04.png',
        'name' => Yii::t('app', 'Экстракт виноградных косточек'),
        'components' => [],
        'link' => ['/main/component/index', 'id' => 1],
    ],
    (object) [
        'image' => '05.png',
        'name' => Yii::t('app', 'Орех кола'),
        'components' => [],
        'link' => ['/main/component/view', 'id' => 23, 'url' => 'cola-nut'],
    ],
    (object) [
        'image' => '06.png',
        'name' => Yii::t('app', 'Аргановое масло'),
        'components' => [],
        'link' => false,
    ],

    (object) [
        'image' => '07.png',
        'name' => Yii::t('app', 'Паприка'),
        'components' => [],
        'link' => false,
    ],
    (object) [
        'image' => '08.png',
        'name' => Yii::t('app', 'Магний'),
        'components' => ['08_01.png', '08_02.png', '08_03.png', '08_04.png', '08_05.png', '08_06.png'],
        'link' => false,
    ],
    (object) [
        'image' => '09.png',
        'name' => Yii::t('app', 'Кошачий коготь'),
        'components' => [],
        'link' => ['/main/component/index', 'id' => 2],
    ],

    (object) [
        'image' => '10.png',
        'name' => Yii::t('app', 'Экстракт листьев гамамелиса'),
        'components' => [],
        'link' => false,
    ],
    (object) [
        'image' => '11.png',
        'name' => Yii::t('app', 'Фукус пузырчатый'),
        'components' => [],
        'link' => false,
    ],
    (object) [
        'image' => '12.png',
        'name' => Yii::t('app', 'Экстракт ягод асаи'),
        'components' => [],
        'link' => ['/main/component/view', 'id' => 12, 'url' => 'garcinia-cambogia'],
    ],

    (object) [
        'image' => '13.png',
        'name' => Yii::t('app', 'Цинк'),
        'components' => ['13_01.png', '13_02.png', '13_03.png', '13_04.png', '13_05.png', '13_06.png'],
        'link' => false,
    ],
    (object) [
        'image' => '14.png',
        'name' => Yii::t('app', 'Экстракт гарцинии камбоджийской'),
        'components' => [],
        'link' => ['/main/component/view', 'id' => 8, 'url' => 'garcinia-cambogia'],
    ],
    (object) [
        'image' => '15.png',
        'name' => Yii::t('app', 'Медь'),
        'components' => ['15_01.png', '15_02.png', '15_03.png', '15_04.png', '15_05.png', '15_06.png'],
        'link' => false,
    ],

    (object) [
        'image' => '16.png',
        'name' => Yii::t('app', 'Экстракт ягод годжи'),
        'components' => [],
        'link' => ['/main/component/view', 'id' => 13, 'url' => 'longevity-berries'],
    ],
    (object) [
        'image' => '17.png',
        'name' => Yii::t('app', 'Плодоножки вишни'),
        'components' => [],
        'link' => ['/main/component/view', 'id' => 9, 'url' => 'cherry-stalks'],
    ],
    (object) [
        'image' => '18.png',
        'name' => Yii::t('app', 'Экстракт плодов померанца'),
        'components' => [],
        'link' => ['/main/component/view', 'id' => 11, 'url' => 'orange-fruit-extract'],
    ],

    (object) [
        'image' => '19.png',
        'name' => Yii::t('app', 'Бархатцы'),
        'components' => [],
        'link' => false,
    ],
    (object) [
        'image' => '20.png',
        'name' => Yii::t('app', 'Витамины группы B'),
        'components' => ['20_01.png', '20_02.png', '20_03.png', '20_04.png', '20_05.png', '20_06.png'],
        'link' => false,
    ],
    (object) [
        'image' => '21.png',
        'name' => Yii::t('app', 'Керамиды'),
        'components' => [],
        'link' => false,
    ],

    (object) [
        'image' => '22.png',
        'name' => Yii::t('app', 'Валериана'),
        'components' => [],
        'link' => false,
    ],
    (object) [
        'image' => '23.png',
        'name' => Yii::t('app', 'Опунция'),
        'components' => [],
        'link' => false,
    ],
    (object) [
        'image' => '24.png',
        'name' => Yii::t('app', 'Экстракт Гинкго Билоба'),
        'components' => [],
        'link' => ['/main/component/index', 'id' => 6],
    ],

    (object) [
        'image' => '25.png',
        'name' => Yii::t('app', 'Соевый лецитин'),
        'components' => ['25_01.png', '25_02.png', '25_03.png', '25_04.png', '25_05.png', '25_06.png'],
        'link' => false,
    ],
    (object) [
        'image' => '26.png',
        'name' => Yii::t('app', 'Омега 3'),
        'components' => [],
        'link' => false,
    ],
    (object) [
        'image' => '27.png',
        'name' => Yii::t('app', 'Кальций'),
        'components' => ['27_01.png', '27_02.png', '27_03.png', '27_04.png', '27_05.png', '27_06.png'],
        'link' => false,
    ],

    (object) [
        'image' => '28.png',
        'name' => Yii::t('app', 'Лаванда'),
        'components' => [],
        'link' => false,
    ],
    (object) [
        'image' => '29.png',
        'name' => Yii::t('app', 'Экстракт листьев зелёного чая'),
        'components' => [],
        'link' => ['/main/component/view', 'id' => 10, 'url' => 'green-tea'],
    ],
    (object) [
        'image' => '30.png',
        'name' => Yii::t('app', 'Glucans 30 экстракт липидов пшеницы'),
        'components' => [],
        'link' => false,
    ],

    (object) [
        'image' => '31.png',
        'name' => Yii::t('app', 'Экстракт бамбука'),
        'components' => [],
        'link' => ['/main/component/view', 'id' => 14, 'url' => 'bamboo-extract'],
    ],
    (object) [
        'image' => '32.png',
        'name' => Yii::t('app', 'Холин'),
        'components' => ['32_01.png', '32_02.png', '32_03.png', '32_04.png', '32_05.png', '32_06.png'],
        'link' => false,
    ],
    (object) [
        'image' => '33.png',
        'name' => Yii::t('app', 'Эхинацея'),
        'components' => [],
        'link' => false,
    ],

    (object) [
        'image' => '34.png',
        'name' => Yii::t('app', 'Ангелика китайская'),
        'components' => [],
        'link' => false,
    ],
    (object) [
        'image' => '35.png',
        'name' => Yii::t('app', 'Морские водоросли'),
        'components' => [],
        'link' => false,
    ],
    (object) [
        'image' => '36.png',
        'name' => Yii::t('app', 'Корень имбиря'),
        'components' => [],
        'link' => false,
    ],

    (object) [
        'image' => '37.png',
        'name' => Yii::t('app', 'Хром'),
        'components' => ['37_01.png', '37_02.png', '37_03.png', '37_04.png', '37_05.png', '37_06.png'],
        'link' => false,
    ],
    (object) [
        'image' => '38.png',
        'name' => Yii::t('app', 'Гуарана'),
        'components' => [],
        'link' => ['/main/component/index', 'id' => 3],
    ],
    (object) [
        'image' => '39.png',
        'name' => Yii::t('app', 'Витамин D3'),
        'components' => ['39_01.png', '39_02.png', '39_03.png', '39_04.png', '39_05.png', '39_06.png'],
        'link' => false,
    ],

    (object) [
        'image' => '40.png',
        'name' => Yii::t('app', 'Масло бораго'),
        'components' => [],
        'link' => false,
    ],
    (object) [
        'image' => '41.png',
        'name' => Yii::t('app', 'Черника'),
        'components' => [],
        'link' => false,
    ],
    (object) [
        'image' => '42.png',
        'name' => Yii::t('app', 'Сод'),
        'components' => [],
        'link' => false,
    ],
    (object) [
        'image' => '43.png',
        'name' => Yii::t('app', 'Органическая спирулина'),
        'components' => [],
        'link' => ['/main/component/view', 'id' => 7, 'url' => 'spirulina'],
    ],
    (object) [
        'image' => '44.png',
        'name' => Yii::t('app', 'Витамин C'),
        'components' => ['44_01.png', '44_02.png', '44_03.png', '44_04.png', '44_05.png', '44_06.png'],
        'link' => false,
    ],
    (object) [
        'image' => '45.png',
        'name' => Yii::t('admin', 'Lalmin® Immune'),
        'components' => [],
        'link' => false,
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
    <?php for ($k = 1; $k <= 3; $k++) { ?>
        <div class="main-components__list-inner main-components__list-inner_<?= $k ?> str_wrap">
        <?php foreach ($arr as $key => $val) { ?>
            <?php if (($key + 2 + $k) % 3 === 0) { ?>
            <div class="main-components__item main-components__item_<?= count($val->components) > 0 ? 'vitamin' : 'not-vitamin' ?>">
                <div class="main-components__image">
                    <?php if ($val->link) { ?>
                    <a href="<?= Url::to($val->link) ?>">
                    <?php } ?>
                        <?= Html::img('@web/storage/components/' . $val->image . '?v=6', ['class' => 'main-components__picture'. ($val->link ? ' active' : '')]) ?>
                    <?php if ($val->link) { ?>
                    </a>
                    <?php } ?>
                    <div class="main-components__components">
                    <?php foreach ($val->components as $j => $component) { ?>
                        <div class="main-components__component i<?= ++$j ?>" style="background-image: url('<?= Url::to('@web/storage/components/' . $component . '?v=6') ?>')"></div>
                    <?php } ?>
                    </div>
                </div>
                <div class="main-components__name">
                    <?= $val->name ?>
                </div>
            </div>
            <?php } ?>
        <?php } ?>
        </div>
    <?php } ?>
    </div>
</section>

<?php

$js = <<< JS

$('.main-components__list-inner_1, .main-components__list-inner_3').liMarquee({
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
