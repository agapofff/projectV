<section class="content">
    <div class="container">

        <div class="row">
            <div class="col-lg-4">
                <h1 class="delivery__title fz3">
                    <?= $model->payment_title ?>
                </h1>
                <div class="delivery__text fz5">
                    <?= $model->payment_text ?>
                </div>
            </div>
            <div class="col-lg-7 offset-lg-1">
                <div class="delivery__border">
                    <div class="delivery__border-wrapper">
                        <div class="delivery__logo-list">
                        <?php foreach ($model->payment_params as $val) { ?>
                            <div class="delivery__logo-item delivery__logo-item_<?= $val ?>"></div>
                        <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="delivery__hr"></div>

        <div class="row">
            <div class="col-lg-4">
                <h2 class="delivery__title fz3">
                    <?= $model->delivery_title ?>
                </h2>
                <div class="delivery__text fz5">
                    <?= $model->delivery_text ?>
                </div>
            </div>
            <div class="col-lg-7 offset-lg-1">
                <div class="delivery__border">
                    <div class="delivery__border-wrapper">
                        <div class="delivery__info">
                            <div class="delivery__info-text fz5">
                                <?= $model->delivery_info ?>
                            </div>
                            <div class="delivery__info-list">
                                <?php foreach ($model->delivery_params as $key => $val) { ?>
                                    <div class="delivery__info-item fz5">
                                        <?= $key ?>
                                        <div class="delivery__info-price"><?= $val ?></div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
