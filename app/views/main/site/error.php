<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = $name;

if (isset($exception->statusCode) && $exception->statusCode === 404) {
    $message = Yii::t('app', 'Такая страница не существует {br}или была удалена.', ['br' => '<br />']);
}

?>

<?php Pjax::begin(['scrollTo' => 0, 'timeout' => 10000, 'options' => [
    'id' => 'app__content',
    'class' => 'app__content app__content_screen content',
]]); ?>

    <div class="content__swiper error">
        <div class="content__wrapper content__wrapper_screen screen error__screen">
            <div class="row screen__row h100">
                <div class="col-md-6 screen__col h100 error__screen-col">
                     <div class="error__content">
                         <div class="error__text">
                             <h1 class="error__title">
                                 <?= Yii::t('app', 'Извините') ?>
                             </h1>
                             <div class="error__subtitle">
                                 <?= str_replace('.', '', $message) ?>
                             </div>
                         </div>
                         <div class="error__btns">
                             <?= Html::a(Yii::t('app', 'Главная'), ['/main/site/index'], ['class' => 'error__btn btn btn_empty', 'data-pjax' => 0]) ?>
                             <?= Html::a(Yii::t('app', 'Магазин'), ['/store/default/catalog'], ['class' => 'error__btn btn btn_empty', 'data-pjax' => 0]) ?>
                         </div>
                     </div>
                </div>
                <div class="col-md-6 screen__col h100 error__screen-col"></div>
            </div>
        </div>
        <div class="content__bg-right error__bg">
        <?php if (isset($exception->statusCode)) { ?>
            <div class="error__code"><?= $exception->statusCode ?></div>
        <?php } ?>
        </div>
    </div>

<?php Pjax::end(); ?>
