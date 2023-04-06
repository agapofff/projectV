
<?php

use yii\web\View;

$js = <<<JS

class Share {

    constructor() {
        this.onLoad();
        this.openBtns();
        this.activateCopy();
        this.makeCopy();
    }

    onLoad() {
        var self = this;
        $(document).on('pjax:success', function() {
            self.activateCopy();
        });
    }

    openBtns() {
        var self = this;
        $(document).on('click', '.share__icon', function() {
            self.showBtns()
        });
    }

    showBtns() {
        var el = $('.share');
        el.toggleClass('share_active');
        el.find('.share__content').toggleClass('share__content_active');
    }

    activateCopy() {
        $(document).ready(function() {
            var currentUrl = $('.share').data('current-url');
            $('.social-share').append('<li><a class="share__link share__link_copy"><textarea id="current-url">' + currentUrl + '</textarea></a></li>');
        });
    }
    
    makeCopy() {
        var self = this;
        $(document).on('click', '.share__link_copy', function() {
            var input = document.getElementById('current-url');
            input.select();
            document.execCommand('copy');
            self.showBtns();
            return false;
        });
        return false;
    }
}

var share = new Share();

JS;
$this->registerJs($js, View::POS_READY, 'share');
