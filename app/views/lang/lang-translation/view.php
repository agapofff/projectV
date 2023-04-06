<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\web\View;
use yii\widgets\Menu;

$this->title = Yii::t('admin', 'Переводы');

?>

<div class="language-translations pb-5">
    <div class="container">
        <h1 class="language-translations__title mt-5 mb-4">
            <?= Html::a(Yii::t('admin', 'Переводы'), ['/lang/lang-translation/index']) ?>
        </h1>

<nav class="navbar navbar-expand navbar-light border border-primary rounded">
    <div class="container-fluid">
        <div class="collapse navbar-collapse">
            <?= str_replace('<li class="nav-item active"><a', '<li class="nav-item"><a class="nav-link active"', Menu::widget([
                'items' => [
                    ['label' => Yii::t('admin', 'Все'), 'url' => ['/lang/lang-translation/view', 'locale_to' => $locale_to], 'active' => empty($untranslated)],
                    ['label' => Yii::t('admin', 'Непереведённые'), 'url' => ['/lang/lang-translation/view', 'locale_to' => $locale_to, 'filter' => 'untranslated'], 'active' => $filter === 'untranslated'],
                    ['label' => Yii::t('admin', 'С переменными'), 'url' => ['/lang/lang-translation/view', 'locale_to' => $locale_to, 'filter' => 'variable'], 'active' => $filter === 'variable'],
                ],
                'options' => [
                    'id' => 'navbar-nav',
                    'class' => 'navbar-nav me-auto mb-lg-0',
                ],
                'itemOptions' => [
                    'class' => 'nav-item',
                ],
                'linkTemplate' => '<a href="{url}" class="nav-link">{label}</a>',
                'activeCssClass' => 'active',
            ])) ?>
        </div>
        <?= Html::a(Yii::t('admin', 'Обновить базу'), ['/lang/lang-translation/messages']) ?>
    </div>
</nav>

<div class="translations-category mt-4">
    <div class="translations-category__header bg-secondary rounded">
        <div class="translations-category__row">
            <div class="translations-category__number text-white">
                #
            </div>
            <div class="translations-category__from text-white px-2">
                <?= $locale_from ?>
            </div>
            <div class="translations-category__to">
                <?php $form = ActiveForm::begin([
                    'id' => 'language-translation-to-form',
                    'method' => 'GET',
                    'action' => Url::to(['/lang/lang-translation/view', 'locale_from' => $locale_from]),
                    'options' => [
                        'class' => 'translations-category__form-locale',
                    ],
                    'fieldConfig' => [
                        'template' => '{input}',
                    ],
                ]); ?>
                    <?= Html::dropDownList('locale_to', $locale_to, ArrayHelper::map($languages, 'iso', 'iso'), [
                        'onchange' => 'this.form.submit();',
                    ]) ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
    <div class="translations-category__body">
    <?php $message = ''; ?>
    <?php foreach ($language_translations as $key => $language_translation) { ?>
        <div class="translations-category__row mt-1 rounded<?= $language_translation->isUntranslated($locale_to) ? ' bg-danger text-white' : ' bg-white' ?><?= $message == $language_translation->ru_ru ? ' border border-warning' : '' ?>"
             data-id="<?= $language_translation->id ?>">
            <div class="translations-category__number">
                <?= ++$key ?>
            </div>
            <?php if (Yii::$app->user->can('admin')) { ?>
            <div class="translations-category__btn-message-delete opacity-50">
                <i class="fas fa-times text-danger"></i>
            </div>
            <?php } ?>
            <div class="translations-category__from">
                <?= $this->renderFile('@app/views/lang/lang-translation/_message.php', [
                    'language_translation' => $language_translation,
                    'locale' => $locale_from,
                    'direction' => 'from',
                ]) ?>
            </div>
            <div class="translations-category__to">
                <?= $this->renderFile('@app/views/lang/lang-translation/_message.php', [
                    'language_translation' => $language_translation,
                    'locale' => $locale_to,
                    'direction' => 'to',
                ]) ?>
            </div>
        </div>
        <?php $message = $language_translation->ru_ru; ?>
    <?php } ?>
    </div>
</div>

    </div>
</div>

<?php

$url_show_form = Url::to(['/lang/lang-translation/form']);
$url_hide_form = Url::to(['/lang/lang-translation/update']);
$url_delete_row = Url::to(['/lang/lang-translation/delete']);

$js = <<<JS

class Translation
{
    constructor() {
        this.showForm();
        this.hideForm();
        this.deleteRow();
    }

    showForm() {
        var self = this;
        $(document).on('click', '.translations-category__message.active', function(event) {

            self.closeForm();
 
            var message = $(this),
                id = message.parents('.translations-category__row').data('id'),
                locale = message.data('locale'),
                direction = message.data('direction');

            $.ajax({
                type: 'POST',
                url: '$url_show_form',
                data: {
                    id: id,
                    locale: locale,
                    direction: direction
                },
                beforeSend: function() {
                    message.css('opacity', .5);
                },
                success: function(data) {
                    message.replaceWith(data);
                    autosize($('textarea'));
                    $('textarea').focus();
                }
            });
            return false;
        });
    }

    hideForm() {
        var self = this;
        $(document).click(function(event) {
            if ($(event.target).closest('.translations-category__form').length) {
                return;
            }

            self.closeForm();

            event.stopPropagation();
        });
    }

    closeForm() {
        var form = $('.translations-category__form'),
            id = form.parents('.translations-category__row').data('id'),
            locale = form.data('locale'),
            message = form.val(),
            direction = form.data('direction');

        if (form.length) {
            $.ajax({
                type: 'POST',
                url: '$url_hide_form',
                data: {
                    id: id,
                    locale: locale,
                    message: message,
                    direction: direction
                },
                beforeSend: function() {
                    form.css('opacity', .5);
                },
                success: function(data) {
                    form.replaceWith(data);
                }
            });
        }
    }

    deleteRow() {
        $(document).on('click', '.translations-category__btn-message-delete', function(event) {
            event.stopImmediatePropagation();
        
            if (!confirm('Are you sure that you want to delete this?')) {
                return false;
            }

            let row = $(this).parents('.translations-category__row'),
                id = row.data('id');

            $.ajax({
                type: 'POST',
                url: '$url_delete_row',
                data: {
                    id: id
                },
                success: function() {
                    row.remove();
                }
            });
        });
    }
}

var translation = new Translation();

JS;

$this->registerJs($js, View::POS_READY);
