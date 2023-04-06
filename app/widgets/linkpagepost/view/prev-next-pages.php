<?php

use yii\helpers\Html;

?>

<div class="content__nav-btn nav-btn">
    <?= $title ?>
    <ul class="nav-btn__list">
    <?php foreach ($buttons as $key => $val) { ?>
        <li class="nav-btn__item">
        <?php if ($val['page'] === $currentPage) { ?>
            <div class="nav-btn__link nav-btn__link_<?= $key ?> nav-btn__link_inactive"></div>
        <?php } else { ?>
            <?= Html::a('', $val['url'], ['class' => 'nav-btn__link nav-btn__link_' . $key]) ?>
        <?php } ?>
        </li>
    <?php } ?>
    </ul>
    <?= $text ?>
</div>
