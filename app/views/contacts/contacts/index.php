<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

$nav_prev = $prev ?
    Html::a('', ['/contacts/contacts/index', 'alias' => $prev->alias], ['class' => 'nav-btn__link nav-btn__link_prev contacts__nav-item']) :
    '<div class="nav-btn__link nav-btn__link_prev nav-btn__link_inactive contacts__nav-item"></div>';
$nav_next = $next ?
    Html::a('', ['/contacts/contacts/index', 'alias' => $next->alias], ['class' => 'nav-btn__link nav-btn__link_next contacts__nav-item']) :
    '<div class="nav-btn__link nav-btn__link_next nav-btn__link_inactive contacts__nav-item"></div>';

?>

<?php Pjax::begin(['scrollTo' => 0, 'timeout' => 10000, 'options' => [
    'id' => 'contacts',
    'class' => 'usual-page contacts',
]]); ?>

    <div class="container">
        <div class="row">
            <div class="col-md-4 screen__col">
                <div class="screen__left-wrapper">
                    <div class="contacts__header">
                        <h1 class="contacts__title fz3">
                            <?= $seoMedatada->h1 ?>
                        </h1>
                        <?php if (!empty($model->subtitle)) { ?>
                        <h2 class="contacts__subtitle">
                            <?= $model->subtitle ?>
                        </h2>
                        <?php } ?>
                        <div class="contacts__nav contacts__nav_mob">
                            <?= $nav_prev ?>
                            <?= $nav_next ?>
                        </div>
                    </div>
                    <div class="contacts__list-value">
                        <?php if (!empty($model->address)) { ?>
                        <div class="contacts__item-value">
                            <span class="contacts__name"><?= Yii::t('app', 'Адрес: {address}', [
                                    'address' => '</span> <span class="contacts__value">' . $model->address . '</span>',
                                ]) ?>
                        </div>
                        <?php } ?>
                        <?php if (!empty($model->phone)) { ?>
                        <div class="contacts__item-value">
                            <span class="contacts__name"><?= Yii::t('app', 'Телефон: {phone}', [
                                    'phone' => '</span> <span class="contacts__value">' . $model->phone . '</span>',
                                ]) ?>
                        </div>
                        <?php } ?>
                        <?php if (!empty($model->whatsapp)) { ?>
                        <div class="contacts__item-value">
                            <span class="contacts__name"><?= Yii::t('app', 'WhatsApp: {whatsapp}', [
                                    'whatsapp' => '</span> <span class="contacts__value">' . $model->whatsapp . '</span>',
                                ]) ?>
                        </div>
                        <?php } ?>
                        <?php if (!empty($model->working_hours)) { ?>
                        <div class="contacts__item-value">
                            <span class="contacts__name"><?= Yii::t('app', 'Часы работы: {working_hours}', [
                                    'working_hours' => '</span> <span class="contacts__value">' . $model->opening_hours . '</span>',
                                ]) ?>
                        </div>
                        <?php } ?>
                        <?php if (!empty($model->email)) { ?>
                        <div class="contacts__item-value">
                            <span class="contacts__name"><?= Yii::t('admin', 'E-mail: {email}', [
                                    'email' => '</span> <span class="contacts__value">' . Html::mailto($model->email) . '</span>',
                                ]) ?>
                        </div>
                        <?php } ?>
                        <?php if (!empty($model->tg)) { ?>
                        <div class="contacts__item-value">
                            <span class="contacts__name"><?= Yii::t('app', 'TG: {tg}', [
                                    'tg' => '</span> <span class="contacts__value">' . Html::mailto($model->tg) . '</span>',
                                ]) ?>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="contacts__list-btn">
                        <div class="contacts__item-btn contacts__item-btn_write btn btn_empty popup-open" data-key="popup-form-write">
                            <?= Yii::t('app', 'Написать') ?>
                        </div>
                        <div class="contacts__item-btn contacts__item-btn_call btn btn_empty popup-open" data-key="popup-form-call">
                            <?= Yii::t('app', 'Позвонить') ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-7 offset-md-1 screen__col">
                <div class="screen__right-wrapper contacts__right-wrapper">
                    <?php if (!empty($model->map)) { ?>
                    <div class="contacts__map"><iframe class="contacts__map-iframe" src="<?= $model->getMap(Yii::$app->language) ?>" width="600" height="400"
                        frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe></div>
                    <?php } ?>
                    <?php if (!empty($model->img) && !empty($model->text)) { ?>
                    <div class="row h100">
                        <div class="col-xl-6 col-lg-5 col-md-4 col-sm-6 h100">
                            <div class="slider-border-horizontal contacts__bg-slider">
                                <div class="contacts__bg-image"
                                     style="background-image: url('<?= Url::to($model->getImg()) ?>')"></div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-7 col-md-8 col-sm-6 h100">
                            <div class="slider-border-vertical">
                                <div class="slider-border-vertical__list slider-border-vertical__list_right">
                                    <div class="slider-border-vertical__item"><?= $model->text ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="contacts__nav contacts__nav_desc">
                        <?= $nav_prev ?>
                        <?= $nav_next ?>
                    </div>
                    <div class="screen__border"></div>
                </div>
            </div>
            <div class="col-12">
                <div class="contacts__list-cities">
                <?php foreach ($list as $key => $val) { ?>
                    <?php if ($val->alias === $alias) { ?>
                    <div class="contacts__item-cities contacts__item-cities_current"><?= $val->city ?></div>
                    <?php } else { ?>
                    <?= Html::a($val->city, $val->getLink(), [
                        'class' => 'contacts__item-cities fz5',
                    ]) ?>
                    <?php } ?>
                <?php } ?>
                </div>
            </div>
        </div>
    </div>

<?php Pjax::end(); ?>

<?= $this->renderFile('@app/views/contacts/contacts/_form-write.php', ['model' => $writeForm]) ?>
<?= $this->renderFile('@app/views/contacts/contacts/_form-call.php', ['model' => $callForm, 'country' => $country]) ?>
