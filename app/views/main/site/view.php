<?= $this->renderFile('@app/views/main/site/_view-video.php', ['category' => $category]) ?>
<?= $this->renderFile('@app/views/main/site/_view-components-' . $category . '.php') ?>
<?= $this->renderFile('@app/views/main/site/_view-img.php', ['category' => $category]) ?>
<?= $this->renderFile('@app/views/main/site/_view-products.php', ['products' => $products, 'category' => $category]) ?>
<?php if (Yii::$app->language === 'ru-RU' || Yii::$app->language === 'en-US' || Yii::$app->language === 'uk-UA') { ?>
<?= $this->renderFile('@app/views/main/site/_view-app.php') ?>
<?php } ?>
