<?php

use app\repositories\ProductRepository;
use yii\helpers\Html;

?>

<?php

print_r($response);

?>

<div class="row mb-2 mb-2">
    <div class="col-4"><?= Yii::t('app', 'Страна: {country}', ['country' => '</div><div class="col-8">' . $request->country]) ?></div>
</div>
<div class="row mb-2">
    <div class="col-4"><?= Yii::t('app', 'Имя: {name}', ['name' => '</div><div class="col-8">' . $request->name]) ?></div>
    <div class="col-4"><?= Yii::t('app', 'Телефон: {phone}', ['phone' => '</div><div class="col-8">' . $request->phone]) ?></div>
</div>

<?php foreach ($request->products as $product) { ?>
<div class="media text-muted pb-2">
    <?php $modelRepository = new ProductRepository(); ?>
    <?php if ($model = $modelRepository->get($product->product_id)) { ?>
    <?= Html::a('', $model->getUrl('log'), ['style' => 'background-image: url("' . $model->coverByCurrencyIso->getUrlPrev() . '"); width: 32px; height: 32px;', 'class' => 'mr-2 rounded']) ?>
    <p class="media-body pb-2 mb-0 small lh-125">
        <strong class="d-block text-gray-dark"><?= Html::a($product->name, $model->getUrl('log')) ?></strong>
    <?php } else { ?>
    <img class="mr-2 rounded bg-primary" style="width: 32px; height: 32px;" data-holder-rendered="true" />
    <p class="media-body pb-2 mb-0 small lh-125">
        <strong class="d-block text-gray-dark"><?= $product->name ?></strong>
    <?php } ?>
        <?= Yii::t('app', '{quantity, plural, one{# штука} few{# штуки} many{# штук} other{# штук}}', ['quantity' => $product->quantity]) ?> —
        <?= Yii::$app->formatter->asCurrency(
            $product->price,
            $product->currency_code,
            [\NumberFormatter::MAX_SIGNIFICANT_DIGITS => 100]
        ) ?>
    </p>
</div>
<?php } ?>
