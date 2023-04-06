<?php

use yii\widgets\Menu;
use app\assets\AppAssetAdminMenu;

AppAssetAdminMenu::register($this);

$user_id = Yii::$app->getUser()->id;

$items = [];
$items[] = [
    'label' => '<i class="fas fa-home"></i>',
    'url' => ['/main/site/index'],
    'options' => ['title' => Yii::t('admin', 'Главная')],
];
if (Yii::$app->user->can('admin')) {
    $items[] = [
        'label' => '<i class="fas fa-globe"></i>',
        'url' => ['/admin/country/index'],
        'options' => ['title' => Yii::t('admin', 'Страны')],
    ];
    $items[] = [
        'label' => '<i class="fas fa-store"></i>',
        'url' => ['/admin/store/index'],
        'options' => ['title' => Yii::t('admin', 'Магазины')],
    ];
}
if (Yii::$app->user->can('translator')) {
    $items[] = [
        'label' => '<i class="fas fa-grip-horizontal"></i>',
        'url' => ['/admin/product/index'],
        'options' => ['title' => Yii::t('admin', 'Продукция')],
    ];
}
if (Yii::$app->user->can('admin')) {
    $items[] = [
        'label' => '<i class="fas fa-shopping-cart"></i>',
        'url' => ['/admin/log/index'],
        'options' => ['title' => Yii::t('admin', 'Логирование')],
    ];
}
$items[] =  [
    'items' => [
        [
            'label' => '<i class="fas fa-cogs"></i>',
            'url' => ['/user/profile/edit'],
            'options' => ['title' => Yii::t('admin', 'Настройки')],
        ],
        [
            'label' => '<i class="fas fa-sign-out-alt"></i>',
            'url' => ['/auth/auth/logout'],
            'options' => ['title' => Yii::t('admin', 'Выйти')],
        ],
    ],
    'options' => [
        'class' => 'settings',
    ]
];
?>

<div class="admin-panel">
    <?= Menu::widget([
        'items' => $items,
        'options' => [
            'id' => 'admin-menu',
            'class' => 'admin-menu',
        ],
        'activeCssClass' => 'active',
        'encodeLabels' => false,
    ]) ?>
</div>
