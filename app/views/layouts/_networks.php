<?php

use yii\helpers\Html;

$arr = Yii::$app->params['social_links'][Yii::$app->params['currency']] ?? [];

?>

<div class="social-networks">
    <ul class="social-networks__list">
    <?php foreach ($arr as $link => $name) { ?>
        <li class="social-networks__item">
            <!--noindex--><?= Html::a(Html::img('@web/front/img/icon__' . $name . '.svg?v=1', ['class' => 'social-networks__img']), $link,
                ['class' => 'social-networks__link', 'target' => '_blank', 'rel' => 'nofollow']) ?><!--/noindex-->
        </li>
    <?php } ?>
    </ul>
</div>
