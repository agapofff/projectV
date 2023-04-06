<?php

/* @var $this \yii\web\View */
/* @var $content string */

use nirvana\jsonld\JsonLDHelper;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Spaceless;
use app\entities\admin\Country;

/*
    <!--link rel="apple-touch-icon" href="<?= Url::to('/front/img/apple-touch-icon/touch-icon-iphone.png?v=1') ?>"-->
    <!--link rel="apple-touch-icon" sizes="76x76" href="<?= Url::to('/front/img/apple-touch-icon/touch-icon-ipad.png?v=1') ?>"-->
    <!--link rel="apple-touch-icon" sizes="120x120" href="<?= Url::to('/front/img/apple-touch-icon/touch-icon-iphone-retina.png?v=1') ?>"-->
    <!--link rel="apple-touch-icon" sizes="152x152" href="<?= Url::to('/front/img/apple-touch-icon/touch-icon-ipad-retina.png?v=1') ?>"-->
*/

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link href="<?= Url::to('@web/favicon.ico?v=6') ?>" rel="shortcut icon" type="image/x-icon" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&display=swap" rel="stylesheet">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="canonical" href="<?= Url::current(['lang_id' => Country::getDefaultLang()], true) ?>" />
    <?php JsonLDHelper::registerScripts(); ?>
    <?php $this->head() ?>

    <?php /* ?>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-TBJTSG2');</script>
    <!-- End Google Tag Manager -->
    <?php */ ?>
</head>
<body class="bg-light">
<?php $this->beginBody() ?>
<?php Spaceless::begin() ?>

    <?php /* ?>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TBJTSG2" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <?php */ ?>

    <?php if (!Yii::$app->user->isGuest) { ?>
        <?= $this->renderFile('@app/views/layouts/_admin-menu.php') ?>
    <?php } ?>

    <?= $content ?>

<?php Spaceless::end() ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
