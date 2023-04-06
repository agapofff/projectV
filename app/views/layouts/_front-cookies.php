<?php

use app\services\main\SiteService;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

?>

<?php if (empty(SiteService::getCookies())) { ?>

<div class="cookies">
    <div class="cookies__wrap">
        <div class="container">
            <div class="cookies__inner">
                <div class="cookies__text">
                    <?= Yii::t('app', 'Мы&nbsp;используем файлы cookie, чтобы сделать сайт {domain_name} лучше. {br}Продолжая им&nbsp;пользоваться, вы&nbsp;соглашаетесь на&nbsp;обработку персональных данных в&nbsp;соответствии {privacy_policy}', [
                        'br' => '<div class="cookies__hr"></div>',
                        'domain_name' => Html::a(Url::home('https'), ['/main/site/index'], ['class' => 'cookies__link']),
                        'privacy_policy' => Html::a(Yii::t('app', 'с&nbsp;политикой конфиденциальности'), ['/main/site/privacy'], ['class' => 'cookies__link']),
                    ]) ?>
                </div>
                <div class="cookies__btn btn btn_white">
                    <?= Yii::t('app', 'Хорошо') ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

$urlSetCookies = Url::to(['/main/site/set-cookies']);

$js = <<<JS

$(document).on('click', '.cookies__btn', function() {
    $.ajax({
        url: '$urlSetCookies',
        type: 'POST',
        success: function(data) {
            $('.cookies').hide(500);
        }
    });
});

JS;
$this->registerJs($js, View::POS_READY, 'os');

?>

<?php } ?>
