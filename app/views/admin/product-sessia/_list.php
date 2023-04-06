<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

?>

<div class="p-4">
    <h2 class="mb-4"><?= Yii::t('admin', 'Магазины и товары') ?></h2>

    <div id="table" class="table-responsive">
        <table class="table table-bordered table-hover mb-0">
            <thead>
                <tr class="thead-light">
                    <th><?= Yii::t('admin', 'Магазин') ?></th>
                    <th><?= Yii::t('admin', 'ID товара') ?></th>
                    <th><?= Yii::t('admin', 'Цена') ?></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($sessias as $sessia) { ?>
                <?php $title = ($store = $sessia->store) ? $store->title . ' (' . $store->getType() . ')' : ''; ?>
                <tr>
                    <td style="width: 33.33%;">
                        <span class="badge badge-warning"><?= $sessia->store_id ?></span>
                        <?= $title ?>
                    </td>
                    <td style="width: 33.33%;">
                        <?= $sessia->id ?>
                    </td>
                    <td style="width: 33.33%;">
                        <?= str_replace('div', 'span', $sessia->getPriceFormatter(1)) ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
