<?php

use yii\helpers\Url;
use yii\web\View;

$svg_icon_close = '<svg viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M24 24L4 4" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/><path d="M24 4L4 24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/></svg>';

?>

<aside class="aside-search">
    <div class="aside-search__header">
        <div class="container">
            <input type="text" class="aside-search__input" placeholder="<?= Yii::t('app', 'Введите текст') ?>" />
            <div class="aside-search__close">
                <div class="aside-search__close-icon">
                    <?= $svg_icon_close ?>
                </div>
                <?= Yii::t('app', 'Закрыть') ?>
            </div>
        </div>
    </div>
    <div class="aside-search__content">
        <div class="container">
            <div class="aside-search__list product-add-to-cart"></div>
        </div>
    </div>
</aside>

<?php

$url_search = Url::to(['/admin/product/search'], true);

$js = <<<JS

class AsideSearch {

    constructor() {
        this.open();
        this.close();
        this.result();
    }

    open() {
        $(document).on('click', '.search-title', function() {
            $('.aside-search').addClass('active');
            $('.aside-search__input').focus();
            $('body').addClass('hidden-search');
        });
    }

    close() {
        $(document).on('click', '.aside-search__close', function() {
            $('.aside-search').removeClass('active');
            $('body').removeClass('hidden-search');
        });
    }

    result() {
        $(document).on('keyup', '.aside-search__input', function(e) {
            var term = $('.aside-search__input').val(),
                el = $('.aside-search__list');
        
            e.preventDefault();
        
            $.ajax({
                type: 'POST',
                url: '$url_search',
                data: {
                    term: term
                },
                dataType : 'json',
                beforesend: function() {
                    el.addClass('search__list_loading');
                },
                success: function(arr) {
                    el.removeClass('search__list_loading').empty();
                    $.each(arr, function(index, value) {
                        el.append(value);
                    });
                }
            });
        });
    }
}

var asideSearch = new AsideSearch();

JS;
$this->registerJs($js, View::POS_READY, 'aside-search');
