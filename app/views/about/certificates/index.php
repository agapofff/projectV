<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

$svg_nav = '<svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 16L12 8" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/><path d="M20 16L12 24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/><rect x="0.5" y="0.5" width="31" height="31" stroke="currentColor"/></svg>';

?>

<section class="certificates usual-page">
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <div class="certificates__left">
                    <div>
                        <h1 class="certificates__title fz2">
                            <?= $seoMedatada->h1 ?>
                        </h1>
                        <div class="certificates__slider-row slider-row">
                            <div class="slider-row__list">
                                <?php foreach ($list as $val) { ?>
                                    <div class="slider-row__item">
                                        <div class="slider-row__content">
                                            <div class="slider-row__img" style="background-image: url('<?= Url::to($val->getImgThumbnail()) ?>')"></div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="slider-row__navs">
                                <div class="slider-row__nav slick-prev"><?= $svg_nav ?></div>
                                <div class="slider-row__nav slick-next"><?= $svg_nav ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 offset-lg-1">
                <div class="certificates__right">
                    <div class="certificates__slider-col slider-col">
                        <div class="slider-col__list">
                        <?php foreach ($list as $val) { ?>
                            <div class="slider-col__item">
                                <div class="row">
                                    <div class="col col-lg-6">
                                        <div class="slider-col__img" style="background-image: url('<?= Url::to($val->getImg()) ?>')"></div>
                                    </div>
                                    <div class="col col-lg-5 offset-lg-1">
                                        <div class="slider-col__text">
                                            <div>
                                                <?= $val->text ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php

$js = <<<JS

class Slider {

    constructor() {
        this.load();
        this.prev();
        this.next();
    }

    load() {

        $('.slider-row__list').slick({
            slidesToShow: 5,
            slidesToScroll: 1,
            infinite: true,
            speed: 250,
            arrows: false,
            focusOnSelect: true,
            asNavFor: '.slider-col__list',
            responsive: [
                {
                    breakpoint: 1199,
                    settings: {
                        slidesToShow: 4
                    }
                },
                {
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 5
                    }
                },
                {
                    breakpoint: 575,
                    settings: {
                        slidesToShow: 3
                    }
                }
            ]
        });

        $('.slider-col__list').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            infinite: true,
            speed: 250,
            arrows: false,
            focusOnSelect: true,
            asNavFor: '.slider-row__list',
            responsive: [
                {
                    breakpoint: 991,
                    settings: {
                        vertical: false
                    }
                }
            ]
        });
    }

    prev() {
        $(document).on('click', '.slick-prev', function(e) {
            $('.slider-row__list, .slider-col__list').slick('slickPrev');
        });
    }

    next() {
        $(document).on('click', '.slick-next', function(e) {
            $('.slider-row__list, .slider-col__list').slick('slickNext');
        });
    }
}

var slider = new Slider();

JS;

$this->registerJs($js, View::POS_READY, 'slider');
