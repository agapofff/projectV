<?php

use yii\web\View;

?>

<?= $this->renderFile('@app/views/main/component/_index-1-3.php', ['model' => $model, 'url' => $url]) ?>
<?= $this->renderFile('@app/views/main/component/_index-4-6.php', ['model' => $model, 'url' => $url]) ?>
<?= $this->renderFile('@app/views/main/component/_index-product.php', ['model' => $model, 'url' => $url, 'product' => $product]) ?>

<style>body {background-color: #fff;}</style>

<?php

// https://github.com/michalsnik/aos

$js = <<<JS

AOS.init({
    easing: 'ease',
    duration: 1000,
    delay: 500,
    offset: 0
});

JS;

$this->registerJs($js, View::POS_READY);
