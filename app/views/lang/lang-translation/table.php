<?php

$this->title = Yii::t('admin', 'Перевод');

?>

<table style="width:100%;">
    <tr>
        <th style="width:46%;">ru-RU</th>
        <th style="width:46%;"><?= $lang->iso ?></th>
    </tr>
    <?php foreach ($translations as $translation) { ?>
    <?php $lang_default_iso_db = $langDefault->getModifyIso(); ?>
    <?php $lang_iso_db = $lang->getModifyIso(); ?>
    <tr>
        <td><pre style="white-space:pre-wrap;margin:1px;"><?= htmlentities($translation->$lang_default_iso_db, ENT_COMPAT, "UTF-8") ?></pre></td>
        <td><pre style="white-space:pre-wrap;margin:1px;"><?= htmlentities($translation->$lang_iso_db, ENT_COMPAT, "UTF-8") ?></pre></td>
    </tr>
    <?php } ?>
</table>
