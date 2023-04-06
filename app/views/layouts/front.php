<?php

use app\assets\AppAsset;
use app\widgets\asidecart\AsideCart;
use app\widgets\asidesearch\AsideSearch;
use app\widgets\asidecountries\AsideCountries;
use app\widgets\asidelanguages\AsideLanguages;

AppAsset::register($this);

?>

<?php $this->beginContent('@app/views/layouts/main.php') ?>
<div id="app" class="app">

    <?= $this->renderFile('@app/views/layouts/_front-cookies.php') ?>
    <?= $this->renderFile('@app/views/layouts/_front-download-app.php') ?>

    <?= $this->renderFile('@app/views/layouts/_front-header.php') ?>

    <?= $content ?>

    <?= $this->renderFile('@app/views/layouts/_front-footer.php') ?>

    <?= AsideCart::widget() ?>
    <?php /*AsideSearch::widget()*/ ?>
    <?= AsideCountries::widget() ?>
    <?= AsideLanguages::widget() ?>

    <?= $this->renderFile('@app/views/layouts/_front-admin.php') ?>

    <?= $this->renderFile('@app/views/layouts/_js-popup.php') ?>
    <?= $this->renderFile('@app/views/layouts/_js-store-products.php') ?>

</div>
<?php $this->endContent() ?>
