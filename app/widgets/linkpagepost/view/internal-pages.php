<?php

use yii\helpers\Html;

?>

<div class="desc">
    <div class="content__nav-bullet nav-bullet">
        <ul id="nav-bullet__list" class="nav-bullet__list">
        <?php foreach ($buttons as $key => $val) { ?>
            <?php if ($val['page'] === $currentPage) { ?>
            <li class="nav-bullet__item nav-bullet__item_active"><div class="nav-bullet__link"></div></li>
            <?php } else { ?>
            <li class="nav-bullet__item"><?= Html::a('', $val['url'], ['class' => 'nav-bullet__link']) ?></li>
            <?php } ?>
        <?php } ?>
        </ul>
    </div>
</div>
