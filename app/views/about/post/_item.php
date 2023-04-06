<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="posts__content">
    <div class="row h100">
        <div class="col-xl-5 offset-xl-2 col-sm-6 h100 posts__left">
            <div class="posts__cover">
                <div class="posts__img-container">
                    <?= Html::a('', $model->getUrl(), [
                        'data-pjax' => 0,
                        'style' => 'background-image: url(' . Url::to($model->getUrlCover()) . ')',
                        'class' => 'posts__img posts__img_' . $model->type,
                    ]) ?>
                </div>
                <?= Html::a(Yii::t('app', 'Подробнее'), $model->getUrl(), [
                    'data-pjax' => 0,
                    'class' => 'posts__btn btn',
                ]) ?>
            </div>
        </div>
        <div class="col-xl-5 col-sm-6 h100 posts__right">
            <div class="posts__info">
                <div class="posts__info-wrapper">
                    <div class="posts__title"><?= $model->title ?></div>
                    <div class="posts__text"><?= $model->getPrevText() ?></div>
                    <div class="posts__date"><?= $model->getDate() ?></div>
                </div>
            </div>
        </div>
    </div>
</div>
