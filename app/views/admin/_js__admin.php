<?php

use yii\helpers\Url;
use yii\jui\JuiAsset;
use yii\web\View;

JuiAsset::register($this);

$class = isset($class) ? '.' . $class . '.list-group' : '.list-group';

$sortable = isset($sortable) ? $sortable : false;
$delete = isset($delete) ? $delete : false;

$js = '';
if ($sortable) {
    $urlSortable = Url::to(['/' . $url . '/position']);
    $alert = Yii::t('admin', 'Что-то пошло не так...');

    $axis = isset($axis) ? $axis : 'y';

    $js .= <<<JS
var appendTo = $('$class').sortable({
    axis: '$axis',
    forcePlaceholderSize: true,
    forceHelperSize: true,
    handle: '.handle',
    items: '.list-group-item',
    update : function () {
        var serial = $(this).sortable('serialize', {key: 'items[]', attribute: 'id'});
        $.ajax({
            url: '$urlSortable',
            type: 'POST',
            data: serial,
            beforeSend: function() {},
            success: function(data) {},
            error: function(request, status, error){
                alert('$alert');
            }
        });
    },
    stop : function () {
        $(this).find('.ui-sortable .li').css({'position': '', 'z-index': ''});
    },
    helper: fixHelper
}, 'appendTo').disableSelection();
var fixHelper = function(e, ui) {
    ui.children().each(function() {
        $(this).width($(this).width());
    });
    return ui;
};
JS;
}

if ($delete) {
    $urlDelete = Url::to(['/' . $url . '/delete']);
    $alert = Yii::t('admin', 'Вы действительно хотите удалить?');

    $js .= <<<JS
$(document).on('click', '$class .delete', function(event) {
    event.stopImmediatePropagation();
    if (!confirm('$alert')) {
        return false;
    }
    var id = $(this).data('id');
    var key = 'id';
    if (!id) {
        id = $(this).data('key');
        key = 'key';
    }
    $.ajax({
        url: '$urlDelete',
        type: 'POST',
        data: {id: id},
        success: function(data) {
            $('$class .list-group-item[data-' + key + '=' + id + ']').remove();
        },
    });
});
JS;
}

$this->registerJs($js, View::POS_READY);
