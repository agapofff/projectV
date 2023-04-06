<?php

$this->title = Yii::t('admin', 'Перевод');

?>

<table style="width:100%;">
    <tr>
        <th colspan="5"><h1><?= $category ?></h1></th>
    </tr>
    <tr>
        <th style="width:16.66%;"><?= $lang_ru->iso ?></th>
        <th style="width:16.66%;"><?= $lang_en->iso ?></th>
        <th style="width:16.66%;"><?= $lang_de->iso ?></th>
        <th style="width:16.66%;"><?= $lang_vi->iso ?></th>
        <th style="width:16.66%;"><?= $lang_it->iso ?></th>
        <th style="width:16.66%;"><?= $lang_uk->iso ?></th>
    </tr>
    <?php foreach ($messages as $message) { ?>
        <?php $empty = empty($translations_en[$message]) || empty($translations_de[$message]) || empty($translations_vi[$message]) || empty($translations_it[$message]) || empty($translations_uk[$message]); ?>
        <?php /*if ($empty) {*/ ?>
        <tr>
            <td style="<?= $empty ? 'color: red;' : '' ?>"><pre style="white-space:pre-wrap;margin:1px;"><?= htmlentities($message, ENT_COMPAT, "UTF-8") ?></pre></td>
            <td style="<?= empty($translations_en[$message]) ? 'background: rgba(255, 0, 0, .05);' : '' ?>"><pre style="white-space:pre-wrap;margin:1px;"><?= $translations_en[$message] ?? '' ?></pre></td>
            <td style="<?= empty($translations_de[$message]) ? 'background: rgba(255, 0, 0, .05);' : '' ?>"><pre style="white-space:pre-wrap;margin:1px;"><?= $translations_de[$message] ?? '' ?></pre></td>
            <td style="<?= empty($translations_vi[$message]) ? 'background: rgba(255, 0, 0, .05);' : '' ?>"><pre style="white-space:pre-wrap;margin:1px;"><?= $translations_vi[$message] ?? '' ?></pre></td>
            <td style="<?= empty($translations_it[$message]) ? 'background: rgba(255, 0, 0, .05);' : '' ?>"><pre style="white-space:pre-wrap;margin:1px;"><?= $translations_it[$message] ?? '' ?></pre></td>
            <td style="<?= empty($translations_uk[$message]) ? 'background: rgba(255, 0, 0, .05);' : '' ?>"><pre style="white-space:pre-wrap;margin:1px;"><?= $translations_uk[$message] ?? '' ?></pre></td>
        </tr>
        <?php /*}*/ ?>
    <?php } ?>
</table>
