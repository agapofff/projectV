<?php

use yii\helpers\Url;
use yii\web\View;

$url = Url::to(['/admin/product-doc/change-title']);

$js = <<<JS
$(document).on('change', '.docs input', function() {
    var id = $(this).data('id');
    var title = $(this).val();

    $.ajax({
        url: '$url',
        type: 'post',
        data: {
            id: id,
            title: title
        },
    });
});
JS;

$this->registerJs($js, View::POS_READY);
