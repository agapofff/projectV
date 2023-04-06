<?php

use yii\web\View;

$js = <<<JS

class Popup {

    constructor() {
        this.open();
        this.close();
    }

    open() {
        $(document).on('click', '.popup-open', function(e) {
            $('body').addClass('popup-active');
            var key = $(this).data('key');
            $('.popup[data-key=' + key + ']').addClass('popup_active');
        });
    }

    close() {
        var self = this;

        $(document).on('click', '.popup-close', function(e) {
            self.setClose();
        });

        $(document).on('click', '.popup_active', function(e) {
            if($(e.target).closest('.popup__inner').length) {
                return true;
            }
            self.setClose();
        });
    }

    setClose() {
        $('body').removeClass('popup-active');
        $('.popup-close').parents('.popup').removeClass('popup_active');
    }
}

var popup = new Popup();

JS;
$this->registerJs($js, View::POS_READY, 'popup');
