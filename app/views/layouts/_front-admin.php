<?php if (Yii::$app->user->can('admin')) { ?>
    <?php
    $arr = [
        (object) [
            'label' => 'lang_id',
            'value' => Yii::$app->params['lang_id'],
        ],
        (object) [
            'label' => 'store_id',
            'value' => Yii::$app->params['store_id'],
        ],
        (object) [
            'label' => 'currency',
            'value' => Yii::$app->params['currency'],
        ],
    ];
    ?>
    <div class="admin-info">
        <?php foreach ($arr as $item) { ?>
            <div class="admin-info__item"><?= $item->label ?> <span class="admin-info__value"><?= $item->value ?></span></div>
        <?php } ?>
    </div>
<?php } ?>
