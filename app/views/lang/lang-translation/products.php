<?php

$this->title = Yii::t('admin', 'Перевод');

?>

<table style="width:100%;">
    <tr>
        <th style="width:46%;">ru-RU</th>
        <th style="width:46%;"><?= $lang->iso ?></th>
    </tr>
    <?php foreach ($productsDefault as $key => $productDefault) { ?>
    <?php $translateDefault = $productDefault->translateByLangId; ?>
    <?php $translate = \app\entities\admin\ProductTranslate::find()->where(['product_id' => $translateDefault->product_id, 'lang_id' => $lang->id])->one(); ?>
    <tr>
        <td><?= $translateDefault->product_id ?></td>
        <td></td>
    </tr>
    <tr>
        <td><pre style="white-space:pre-wrap;margin:1px;"><?= htmlentities($translateDefault->title, ENT_COMPAT, "UTF-8") ?></pre></td>
        <td><pre style="white-space:pre-wrap;margin:1px;"><?= !empty($translate) ? htmlentities($translate->title, ENT_COMPAT, "UTF-8") : '' ?></pre></td>
    </tr>
    <tr>
        <td><pre style="white-space:pre-wrap;margin:1px;"><?= htmlentities($translateDefault->description, ENT_COMPAT, "UTF-8") ?></pre></td>
        <td><pre style="white-space:pre-wrap;margin:1px;"><?= !empty($translate) ? htmlentities($translate->description, ENT_COMPAT, "UTF-8") : '' ?></pre></td>
    </tr>
    <tr>
        <td><pre style="white-space:pre-wrap;margin:1px;"><?= htmlentities($translateDefault->properties, ENT_COMPAT, "UTF-8") ?></pre></td>
        <td><pre style="white-space:pre-wrap;margin:1px;"><?= !empty($translate) ? htmlentities($translate->properties, ENT_COMPAT, "UTF-8") : '' ?></pre></td>
    </tr>
    <tr>
        <td><pre style="white-space:pre-wrap;margin:1px;"><?= htmlentities($translateDefault->benefits, ENT_COMPAT, "UTF-8") ?></pre></td>
        <td><pre style="white-space:pre-wrap;margin:1px;"><?= !empty($translate) ? htmlentities($translate->benefits, ENT_COMPAT, "UTF-8") : '' ?></pre></td>
    </tr>
    <tr>
        <td><pre style="white-space:pre-wrap;margin:1px;"><?= htmlentities($translateDefault->main_components, ENT_COMPAT, "UTF-8") ?></pre></td>
        <td><pre style="white-space:pre-wrap;margin:1px;"><?= !empty($translate) ? htmlentities($translate->main_components, ENT_COMPAT, "UTF-8") : '' ?></pre></td>
    </tr>
    <tr>
        <td><pre style="white-space:pre-wrap;margin:1px;"><?= htmlentities($translateDefault->composition, ENT_COMPAT, "UTF-8") ?></pre></td>
        <td><pre style="white-space:pre-wrap;margin:1px;"><?= !empty($translate) ? htmlentities($translate->composition, ENT_COMPAT, "UTF-8") : '' ?></pre></td>
    </tr>
    <tr>
        <td><pre style="white-space:pre-wrap;margin:1px;"><?= htmlentities($translateDefault->recommendations, ENT_COMPAT, "UTF-8") ?></pre></td>
        <td><pre style="white-space:pre-wrap;margin:1px;"><?= !empty($translate) ? htmlentities($translate->recommendations, ENT_COMPAT, "UTF-8") : '' ?></pre></td>
    </tr>
    <tr>
        <td><pre style="white-space:pre-wrap;margin:1px;"><?= htmlentities($translateDefault->dosage, ENT_COMPAT, "UTF-8") ?></pre></td>
        <td><pre style="white-space:pre-wrap;margin:1px;"><?= !empty($translate) ? htmlentities($translate->dosage, ENT_COMPAT, "UTF-8") : '' ?></pre></td>
    </tr>
    <tr>
        <td><pre style="white-space:pre-wrap;margin:1px;"><?= htmlentities($translateDefault->storage, ENT_COMPAT, "UTF-8") ?></pre></td>
        <td><pre style="white-space:pre-wrap;margin:1px;"><?= !empty($translate) ? htmlentities($translate->storage, ENT_COMPAT, "UTF-8") : '' ?></pre></td>
    </tr>
    <tr>
        <td><pre style="white-space:pre-wrap;margin:1px;"><?= htmlentities($translateDefault->issue, ENT_COMPAT, "UTF-8") ?></pre></td>
        <td><pre style="white-space:pre-wrap;margin:1px;"><?= !empty($translate) ? htmlentities($translate->issue, ENT_COMPAT, "UTF-8") : '' ?></pre></td>
    </tr>
    <tr>
        <td><pre style="white-space:pre-wrap;margin:1px;"><?= htmlentities($translateDefault->used_for, ENT_COMPAT, "UTF-8") ?></pre></td>
        <td><pre style="white-space:pre-wrap;margin:1px;"><?= !empty($translate) ? htmlentities($translate->used_for, ENT_COMPAT, "UTF-8") : '' ?></pre></td>
    </tr>
    <tr>
        <td><br></td>
        <td></td>
    </tr>
    <?php } ?>
    <?php /*foreach ($translations as $translation) { ?>
    <?php $lang_default_iso_db = $langDefault->getModifyIso(); ?>
    <?php $lang_iso_db = $lang->getModifyIso(); ?>
    <tr>
        <td><pre style="white-space:pre-wrap;margin:1px;"><?= htmlentities($translation->$lang_default_iso_db, ENT_COMPAT, "UTF-8") ?></pre></td>
        <td><pre style="white-space:pre-wrap;margin:1px;"><?= htmlentities($translation->$lang_iso_db, ENT_COMPAT, "UTF-8") ?></pre></td>
    </tr>
    <?php }*/ ?>
</table>
