<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

?>

<?php /*if (!empty(Yii::$app->params['os']) && Yii::$app->params['currency'] === 'RUB') { ?>

<div class="app-download">
    <div class="app-download__close">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M18 6L6 18" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M6 6L18 18" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </div>
    <div class="app-download__img"></div>
    <div class="app-download__text">
        <b><?= Yii::t('app', 'Скачайте приложение ProjectV&nbsp; {br}незаменимый помощник для&nbsp;партнеров и&nbsp;клиентов', ['br' => '</b><br />']) ?>
    </div>
    <div class="app-download__btn">
        <?= Html::a(Yii::t('app', 'Установить'),
            Yii::$app->params['os'] === 'ios' ? 'https://apps.apple.com/ru/app/project-v/id1220488838' : 'https://play.google.com/store/apps/details?id=com.sessia&hl=ru',
            ['target' => '_blank', 'class' => 'app-download__link']) ?>
    </div>
</div>

<?php

$urlSetOs = Url::to(['/main/site/set-os']);

$js = <<<JS

$(document).on('click', '.app-download__close', function() {
    $.ajax({
        url: '$urlSetOs',
        type: 'POST',
        success: function(data) {
            $('.app-download').hide(500);
        }
    });
});

JS;
$this->registerJs($js, View::POS_READY, 'os');

?>

<?php }*/ ?>
