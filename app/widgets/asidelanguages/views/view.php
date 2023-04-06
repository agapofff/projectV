<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

?>

<aside class="aside-language">
    <div class="aside-language__current">
        <div class="aside-language__title aside-language__title_current">
            <div class="aside-language__value"><?= substr(mb_strtolower($langCurrent->iso), 0, 2) ?></div>
            <?= Yii::t('app', 'Язык сайта') ?>
        </div>
    </div>
    <ul class="aside-language__list">
    <?php foreach ($langs as $lang) { ?>
        <li class="aside-language__item">
            <?= Html::a('<div class="aside-language__value">' . substr(mb_strtolower($lang->iso), 0, 2) . '</div>' . $lang->name,
                Url::current(['lang_id' => $lang->id]),
                ['class' => 'aside-language__title']) ?>
        </li>
    <?php } ?>
    </ul>
</aside>

<?php

$js = <<<JS

class AsideLanguage {

    constructor() {
        this.open();
        this.close();
    }

    open() {
        $(document).on('click', '.language-title', function() {
            $('.aside-language').toggleClass('active');
            $('body').toggleClass('hidden-language');
        });
    }

    close() {
        $(document).on('click', function(event) {
            if (!$(event.target).closest('.aside-language, .language-title').length) {
                $('.aside-language').removeClass('active');
                $('body').removeClass('hidden-language');
            }
        });
    }
}

var asideLanguage = new AsideLanguage();

JS;
$this->registerJs($js, View::POS_READY, 'aside-language');
