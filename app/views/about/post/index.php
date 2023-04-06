<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

?>

<div class="app__content app__content_screen content">

    <div class="content__swiper posts">
        <div class="content__wrapper content__wrapper_screen screen">
            <?php if (Yii::$app->user->can('post') || Yii::$app->user->can('seo')) { ?>
                <div class="posts__tools">
                    <?= Html::a('<i class="fas fa-plus"></i>',
                        ['/about/post/add', 'type' => $type],
                        ['class' => 'posts__tool-btn', 'data-pjax' => 0]) ?>
                </div>
            <?php } ?>
            <?php ?>
            <div class="post-slider">
                <div class="post-slider__frame">
                    <ul class="post-slider__list">
                        <?= $this->renderFile('@app/views/about/post/_row.php', [
                            'models' => $models,
                            'lastModel' => $lastModel,
                        ]) ?>
                    </ul>
                </div>
                <div class="post-slider__scrollbar">
                    <div class="post-slider__handle">
                        <div class="post-slider__mousearea"></div>
                    </div>
                </div>
            </div>
            <?php ?>
        </div>
    </div>
</div>

<?php

$url_load = Url::to(['/about/post/load', 'type' => $type], true);

$js = <<<JS

var counter = 0;

var sly = new Sly('.post-slider__frame', {
    itemNav: 'basic',
    smart: 1,
    activateOn: 'click',
    mouseDragging: 1,
    touchDragging: 1,
    releaseSwing: 1,
    startAt: 0,
    scrollBar: $('.post-slider__scrollbar'),
    scrollBy: 1,
    scrollTrap: true,
    activatePageOn: 'click',
    speed: 300,
    elasticBounds: 1,
    easing: 'easeOutExpo',
    dragHandle: 1,
    dynamicHandle: 1
}).init();

sly.on('change', function () {
    if (this.pos.dest === this.pos.end) {
        if (!$('.post-slider__article').hasClass('post-slider__article_last')) {
            load();
        }
    }
});

$(window).resize(function() {
    sly.on('reload');
});

$(window).scroll(function() {
    var scroll = $(window).scrollTop() + $(window).height();
    var offset = $('.content').offset().top + $('.content').outerHeight();
    console.log(scroll, offset);
    if (scroll >= offset && counter === 0) {
        load();
        counter = 1;
    }
});

function load() {
    $.ajax({
        type: 'POST',
        url: '$url_load',
        data: {
            id: $('.post-slider__article').last().data('id')
        },
        beforeSend: function() {
            counter = 1;
            $('.post-slider').css({opacity: .5});
        },
        success: function(data) {
            counter = 0;
            $('.post-slider').css({opacity: 1});
            sly.add(data);
        }
    });
}

JS;

$this->registerJs($js, View::POS_READY);