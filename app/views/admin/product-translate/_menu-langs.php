<?php

use yii\helpers\Html;

?>

<div class="px-4 pt-4">
    <div class="row">
        <div class="col-6">
            <div class="p-3 bg-secondary text-white font-weight-bold rounded" style="height: 54px; line-height: 24px;">
                <span class="badge badge-light float-right" style="line-height: 18px;"><?= $langDefault->iso ?></span>
                <div class="dropdown">
                    <div class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor: pointer;"><?= $langDefault->name ?></div>
                    <div class="dropdown-menu">
                    <?php foreach ($langs as $key => $val) { ?>
                        <?= Html::a(
                            $val->name,
                            array_filter(['/admin/product/form', 'id' => $id, 'currencyIso' => $currencyIso, 'lang' => $lang->id, 'langDefault' => $val->id]),
                            ['class' => 'dropdown-item']
                        ) ?>
                    <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="p-3 bg-secondary text-white font-weight-bold border-left border-light rounded" style="height: 54px; line-height: 24px;">
                <span class="badge badge-light float-right" style="line-height: 18px;"><?= $lang->iso ?></span>
                <?php if (Yii::$app->user->can('admin')) { ?>
                <div class="dropdown">
                    <div class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor: pointer;"><?= $lang->name ?></div>
                    <div class="dropdown-menu">
                    <?php foreach ($langs as $key => $val) { ?>
                        <?= Html::a(
                            $val->name,
                            array_filter(['/admin/product/form', 'id' => $id, 'currencyIso' => $currencyIso, 'lang' => $val->id, 'langDefault' => $langDefault->id]),
                            ['class' => 'dropdown-item']
                        ) ?>
                    <?php } ?>
                    </div>
                </div>
                <?php } else { ?>
                    <?= $lang->name ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
