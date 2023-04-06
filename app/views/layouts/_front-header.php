<?php

use app\services\main\SiteService;
use app\widgets\asidecart\AsideCart;
use app\widgets\asidecountries\AsideCountries;
use app\widgets\asidelanguages\AsideLanguages;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Menu;

$svg_icon_open = '<svg viewBox="0 0 48 24" fill="none" xmlns="http://www.w3.org/2000/svg"><line x1="12" y1="4.5" x2="48" y2="4.5" stroke="currentColor"/><line y1="11.5" x2="36" y2="11.5" stroke="currentColor"/><line x1="12" y1="18.5" x2="48" y2="18.5" stroke="currentColor"/></svg>';
$svg_icon_close = '<svg viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M24 24L4 4" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/><path d="M24 4L4 24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/></svg>';

?>

<header class="header">
    <div class="header__container container">
        <?= Html::a(null, ['/main/site/index'], ['class' => 'header__logo', 'style' => 'background-image: url(' . Url::to('@web/storage/logo.svg?v=1' . ')')]) ?>
        <div class="header__menu">
            <?= $svg_icon_open ?>
        </div>
        <div class="header__tools tools">
            <ul class="tools__list">
                <?= AsideCart::widget([
                    'only_icon' => true,
                ]) ?>
                <?php /*AsideSearch::widget([
                    'only_icon' => true,
                ])*/ ?>
                <li class="tools__item sessia-title">
                    <a class="tools__link language-title__value" href="https://web.project-v.sessia.com" target="_blank">
                        <svg width="20" height="20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M17.602 16.497A9.96 9.96 0 0 0 20 10c0-5.523-4.477-10-10-10S0 4.477 0 10s4.477 10 10 10a9.965 9.965 0 0 0 6.8-2.669l.001.001c.283-.262.55-.54.801-.834Zm-1.15-.221A8.973 8.973 0 0 1 10 19a8.973 8.973 0 0 1-6.45-2.723 7.002 7.002 0 0 1 12.901-.001Zm.716-.833a8.02 8.02 0 0 0-4.93-4.126 4 4 0 1 0-4.473 0 8.021 8.021 0 0 0-4.932 4.127 9 9 0 1 1 14.336-.002ZM13.002 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" fill="currentColor"/></svg>
                    </a>
                </li>
                <?= AsideCountries::widget([
                    'only_icon' => true,
                ]) ?>
                <?= AsideLanguages::widget([
                    'only_icon' => true,
                ]) ?>
            </ul>
        </div>
    </div>
</header>

<menu class="menu">
    <div class="container menu__container">
        <div class="menu__close">
            <div class="menu__close-icon">
                <?= $svg_icon_close ?>
            </div>
            <?= Yii::t('app', 'Закрыть') ?>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <?= Menu::widget(array_merge(
                    ['items' => SiteService::getMenu()],
                    SiteService::getSettingMenu()
                )) ?>
            </div>
        </div>
    </div>
</menu>

<?php

$js = <<<JS

function mainMenuScroll() {
    $('.header').toggleClass('scroll', $(window).scrollTop() > 0);
}

$(window).scroll(function() {
    mainMenuScroll();
});

mainMenuScroll();


class Menu {

    constructor() {
        this.open();
        this.close();
        this.active();
    }

    open() {
        $(document).on('click', '.header__menu', function() {
            $('.menu').addClass('active');
            $('body').addClass('hidden-menu');
        });
    }

    close() {
        var self = this;
        
        $(document).on('click', function(event) {
            if (!$(event.target).closest('.menu, .header__menu').length) {
                self.closeTemplate();
            }
        });

        $(document).on('click', '.menu__close', function() {
            self.closeTemplate();
        });
    }

    closeTemplate() {
        $('.menu').removeClass('active');
        $('body').removeClass('hidden-menu');
    }

    active() {
        if (!$('.menu__item.active').length) {
            $('.menu__list').find('> .menu__item:first-child').addClass('active');
        }
        $(document).on('mouseover', '.menu__item', function() {
            $('.menu__item').removeClass('active');
            $(this).addClass('active');
        });
    }
}

var menu = new Menu();

JS;
$this->registerJs($js, View::POS_READY, 'menu');
