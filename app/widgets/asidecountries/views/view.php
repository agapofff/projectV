<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

?>

<aside class="aside-country">
    <div class="aside-country__current">
        <div class="aside-country__title aside-country__title_current">
            <div class="flag flag_<?= mb_strtolower($countryCurrent->iso) ?> aside-country__flag"></div>
            <?= Yii::t('app', 'Доставка в страну') ?>
        </div>
    </div>
    <ul class="aside-country__list">
    <?php foreach ($countries as $country) { ?>
        <li class="aside-country__item">
            <?= Html::a('<div class="flag flag_' . mb_strtolower($country->iso) . ' aside-country__flag"></div>' . $country->getLocalTitle(),
                Url::current(['country_id' => $country->id, 'domain_current' => $_SERVER['SERVER_NAME'], 'domain_new' => $country->domain]),
                ['class' => 'aside-country__title']) ?>
        </li>
    <?php } ?>
    </ul>
</aside>

<?php

$js = <<<JS

class AsideCountry {

    constructor() {
        this.open();
        this.close();
    }

    open() {
        $(document).on('click', '.country-title', function() {
            $('.aside-country').toggleClass('active');
            $('body').toggleClass('hidden-country');
        });
    }

    close() {
        $(document).on('click', function(event) {
            if (!$(event.target).closest('.aside-country, .country-title').length) {
                $('.aside-country').removeClass('active');
                $('body').removeClass('hidden-country');
            }
        });
    }
}

var asideCountry = new AsideCountry();

JS;
$this->registerJs($js, View::POS_READY, 'aside-country');
