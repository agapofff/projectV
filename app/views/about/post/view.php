<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\View;
use yii\helpers\StringHelper;
use yii\widgets\Pjax;
use ymaker\social\share\widgets\SocialShare;

?>

<?php Pjax::begin(['scrollTo' => 0, 'timeout' => 10000, 'options' => [
    'id' => 'content',
    'class' => 'content post',
]]); ?>

    <?php
    $currentUrl = Url::current([], true);
    $currentUrl = stristr($currentUrl, '?', true) ? stristr($currentUrl, '?', true) : $currentUrl;
    ?>

    <div class="content__swiper">
        <div class="content__wrapper content__wrapper_screen screen">
            <div class="screen__mob">
                <div class="post__bg-image h100" style="background-image: url('<?= Url::to($model->getUrlImg()) ?>')"></div>
            </div>
            <div class="row screen__row h100">
                <div class="col-md-6 screen__col screen__col h100">
                    <div class="screen__left-wrapper post__left-wrapper h100">
                        <div class="row h100">
                            <div class="col-xl-10 offset-xl-2 h100">
                                <div class="post__content scrollbar-rail">
                                    <h1 class="screen__title">
                                        <?= nl2br($seoMedatada->h1) ?>
                                    </h1>
                                    <div class="post__date">
                                        <?= $model->getDate() ?>
                                    </div>
                                    <div class="screen__text post__text">
                                        <?= $model->text ?>
                                    </div>
                                    <div class="post__share share" data-current-url="<?= $currentUrl ?>">
                                        <?= SocialShare::widget([
                                            'configurator' => 'socialShare',
                                            'url' => $currentUrl,
                                            'title' => $model->metadata_title,
                                            'description' => StringHelper::truncate(strip_tags($model->metadata_description), 150, '...'),
                                            'imageUrl' => Url::to($model->getUrlCover(), true),
                                        ]); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 screen__col h100 post__col">
                    <div class="screen__right-wrapper post__right-wrapper">
                        <div class="row w100 h100">
                            <div class="col-12">
                                <div class="post__bg-image h100" style="background-image: url('<?= Url::to($model->getUrlImg()) ?>')">
                                <?php if (Yii::$app->user->can('post') || Yii::$app->user->can('seo')) { ?>
                                    <div class="post__tools">
                                        <?= Html::a('<i class="fas fa-edit"></i>',
                                            ['/about/post/form', 'type' => $model->type, 'id' => $model->id],
                                            ['class' => 'post__tool-btn', 'data-pjax' => 0]) ?>
                                        <?= Html::a('<i class="fas fa-trash-alt"></i>',
                                            ['/about/post/delete', 'type' => $model->type, 'id' => $model->id],
                                            ['class' => 'post__tool-btn post__tool-btn_delete', 'data-pjax' => 0]) ?>
                                    </div>
                                <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content__bg-right"></div>
    </div>

<?php Pjax::end(); ?>

<?= $this->renderFile('@app/views/layouts/_js-share.php') ?>

<?php

$js = '';

if (Yii::$app->user->can('post') || Yii::$app->user->can('seo')) {
    $text = Yii::t('admin', 'Вы действительно хотите удалить?');
    $js .= <<<JS

    $(document).on('click', '.post__tool-btn_delete', function(event) {
        event.stopImmediatePropagation();
        if (!confirm('$text')) {
            return false;
        }
    });
JS;
}
$js .= <<<JS

class Post {

    constructor() {
        this.onLoad();
        this.loadScrollbarRail();
    }

    onLoad() {
        var self = this;
        $(document).on('pjax:success', function() {
            self.loadScrollbarRail();
        });
    }

    loadScrollbarRail() {
        $(document).ready(function() {
            $('.scrollbar-rail').scrollbar();
        });
    }
}

var post = new Post();

JS;

$this->registerJs($js, View::POS_READY, 'community-post');
