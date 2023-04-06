<?php

use yii\helpers\Url;

$arr = [
    (object) [
        'img' => 'at-002.jpg',
        'title' => 'Marija Kostovski',
        'subtitle' => 'Director and Business Development Manager for EU',
    ],
    (object) [
         'img' => 'at-003.jpg',
         'title' => 'Natalia Hinteregger',
         'subtitle' => 'Logistics and Parcel shipment Manager',
    ],
    (object) [
         'img' => 'at-001.jpg',
         'title' => 'Ivana Osmanovic',
         'subtitle' => 'Office Manager',
    ],
    (object) [
         'img' => 'at-005.jpg',
         'title' => 'Evelina Iusip',
         'subtitle' => 'Administrator',
    ],
];

?>

<div class="team">
    <div class="container">
        <h1 class="team__title fz2"><?= Yii::t('app', 'Команда') ?></h1>
        <div class="team__at-office">
            <br>
            <br>
            <img src="<?= Url::to('@web/storage/about/team/at-office.jpeg?v=1') ?>" alt="">
        </div>
        <div class="team__list team__list_at">
        <?php $i = 1; ?>
        <?php foreach ($arr as $val) { ?>
            <div class="team__item team__item_at">
                <div class="team__avatar team__avatar_at" style="background-image: url('<?= Url::to('@web/storage/about/team/' . $val->img . '?v=1') ?>')"></div>
                <div class="team__info">
                    <div class="team__name"><?= $val->title ?></div>
                    <div class="team__position"><?= $val->subtitle ?></div>
                </div>
            </div>
            <?php $i++; ?>
        <?php } ?>
        </div>
        <div class="team__at-team" style="background-image: url('<?= Url::to('@web/storage/about/team/at-team.jpg?v=1') ?>')"></div>
    </div>
</div>
