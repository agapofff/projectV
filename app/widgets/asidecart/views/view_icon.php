<?php

use yii\helpers\Html;

?>

<li class="tools__item cart-title">
    <?= Html::a('<svg width="22" height="20" viewBox="0 0 22 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18.325 5.5H3.67497C3.09301 5.5 2.59634 5.91231 2.50067 6.47487L0.516493 18.1415C0.395551 18.8527 0.955138 19.5 1.6908 19.5H20.3092C21.0449 19.5 21.6044 18.8527 21.4835 18.1415L19.4993 6.47487C19.4037 5.91232 18.907 5.5 18.325 5.5Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/><path d="M6 5.5C6 2.73858 8.23858 0.5 11 0.5C13.7614 0.5 16 2.73858 16 5.5" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/></svg><span class="cart-title__products-quantity"></span>',
        ['/store/default/cart'],
        ['class' => 'tools__link icon-cart cart-title__value']) ?>
</li>
