<div class="mission usual-page">
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <h1 class="mission__title fz2"><?= $model->title ?></h1>
                <div class="mission__subtitle fz4"><?= $model->subtitle ?></div>
                <div class="mission__text"><?= $model->text ?></div>
                <div class="desktop tablet">
                    <ul class="mission__list">
                        <?php foreach ($model->params as $key => $val) { ?>
                            <li class="mission__item">
                                <b><?= $key ?></b>
                                <span class="fz5"><?= $val ?></span>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6 offset-lg-1">
                <div class="mission__right">
                    <div class="mission__video video">
                        <?= $model->video ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="mobile">
            <ul class="mission__list">
                <?php foreach ($model->params as $key => $val) { ?>
                    <li class="mission__item">
                        <b><?= $key ?></b>
                        <span class="fz5"><?= $val ?></span>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>
