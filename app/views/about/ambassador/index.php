<?php

use yii\helpers\Url;

?>

<div class="ambassadors usual-page">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 offset-xl-1">
                <div class="ambassadors__title"></div>
            </div>
        </div>
        <div class="ambassadors__list row">
        <?php foreach ($ambassadors as $ambassador) { ?>
            <div class="col-xl-3 col-lg-4 col-md-6 ambassadors__item">
                <a class="ambassadors__avatar" href="<?= Url::to(['/about/ambassador/view', 'id' => $ambassador->id]) ?>">
                    <span class="ambassadors__img" style="background-image: url('<?= Url::to('@web/storage/about/ambassadors/' . str_replace('.jpg', '-q.jpg', $ambassador->avatar . '?v=1')) ?>')"></span>
                </a>
                <div class="ambassadors__name fz4-5"><?= $ambassador->getTitle() ?></div>
                <div class="ambassadors__city"><?= $ambassador->getCity() ?></div>
            </div>
        <?php } ?>
        </div>
    </div>
</div>
