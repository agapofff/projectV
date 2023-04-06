<?php

use app\entities\lang\LangTranslation;
use yii\helpers\Html;

$this->title = Yii::t('admin', 'Переводы');

?>

<div class="language-translations">
    <div class="container">
        <h1 class="language-translations__title mt-5 mb-0"><?= $this->title ?></h1>
        <?php foreach ($languages as $key => $language) { ?>
            <?php $untranslated_messages = LangTranslation::getUntranslated($language->iso); ?>
            <?php $translated_messages = LangTranslation::getTranslated($language->iso); ?>
            <?php $sum = $untranslated_messages + $translated_messages; ?>
            <div class="language-translations__item mt-4">
                <?= Html::a('<div class="w-100">' .$language->iso . '</div><small>' . $translated_messages . ' / ' . $sum . '</small>',
                    ['/lang/lang-translation/view', 'locale_from' => $locale_from, 'locale_to' => $language->iso],
                    ['class' => 'language-translations__category-link d-flex btn btn-lg ' . ($untranslated_messages == 0 ? 'btn-success' : 'btn-danger')]) ?>
                <div class="language-translations__translators">
                    <?php foreach ($language->langTranslators as $translator) { ?>
                    <?php if ($translator->user) { ?>
                        <div class="language-translations__translator mt-2">
                            <?= $translator->user->username ?>
                        </div>
                    <?php } ?>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
