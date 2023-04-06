<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Pjax;

?>

<div class="ambassadors usual-page">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 offset-xl-1">
                <?= Html::a(null, ['/about/ambassador/index/'], ['class' => 'ambassadors__title']) ?>
            </div>
        </div>
    </div>
    <div class="ambassador-nav swiper">
        <div class="swiper-wrapper">
        <?php $i = 0; ?>
        <?php $initialSlide = 1; ?>
        <?php foreach ($ambassadors as $key => $val) { ?>
            <?php if ($ambassador->id === $val->id) {$initialSlide = $i;} ?>
            <div class="ambassador-nav__item swiper-slide" data-url="<?= Url::to(['/about/ambassador/view', 'id' => $val->id]) ?>" data-index="<?= $i ?>">
                <?= Html::tag('div', null, [
                    'class' => 'ambassador-nav__img',
                    'style' => 'background-image: url(' . Url::to('@web/storage/about/ambassadors/' . str_replace('.jpg', '-q.jpg', $val->avatar . '?v=1')) . ')',
                ]) ?>
            </div>
            <?php $i++; ?>
        <?php } ?>
        </div>
    </div>
    <?php Pjax::begin(['timeout' => 10000, 'options' => [
        'id' => 'ambassadors-view',
        'class' => 'ambassadors-view',
        'linkSelector' => '.ambassador-nav__item',
    ]]); ?>
        <div class="container">
            <div class="ambassador">
                <div class="row">
                    <div class="col-lg-4 offset-lg-1 col-md-5">
                        <div class="ambassador__img" style="background-image: url('<?= Url::to('@web/storage/about/ambassadors/' . str_replace('.jpg', '-q.jpg', $ambassador->avatar . '?v=1')) ?>')"></div>
                    </div>
                    <div class="col-lg-5 offset-lg-1 col-md-6 offset-md-1">
                        <div class="ambassador__name fz3"><?= $ambassador->getTitle() ?></div>
                        <div class="ambassador__city"><?= $ambassador->getCity() ?></div>
                        <div class="ambassador__text"><?= $ambassador->getText() ?></div>
                    </div>
                </div>
            </div>
        </div>
    <?php Pjax::end() ?>
</div>

<?php

$js = <<<JS

var swiper = new Swiper(".ambassador-nav", {
    slidesPerView: "auto",
    centeredSlides: true,
    slideToClickedSlide: true,
    spaceBetween: 0,
    speed: 0,
    shortSwipes: false,
    allowTouchMove: true,
    loop: true,
    initialSlide: $initialSlide,
    breakpoints: {
        768: {
            allowTouchMove: false
        }
    }
});

$(document).on('click', '.ambassador-nav__item', function(e) {
    e.preventDefault();
    swiper.slideToLoop($(this).data('index'), 0);
});

swiper.on('slideChange', function (swiper) {
    $.pjax({
        url: $('.ambassador-nav__item[data-index=' + swiper.realIndex + ']').data('url'),
        container: '#ambassadors-view',
        scrollTo: $('.ambassador-nav').offset().top - $('.header').outerHeight()
    });
});

JS;
$this->registerJs($js, View::POS_READY);
