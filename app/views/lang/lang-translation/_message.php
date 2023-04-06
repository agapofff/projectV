<?php

$message = $language_translation->getMessage($locale);
$_message = $language_translation->$message;

/*
$subject = $_message;
$pattern = '/\{(.*)\}/';
preg_match_all($pattern, $subject, $matches);
*/

?>

<?php if ($direction === 'from') { ?>
<div class="translations-category__message">
<?php } elseif ($direction === 'to') { ?>
<div class="translations-category__message active<?= empty($language_translation->$message) ? ' empty text-white' : '' ?>" data-locale="<?= $locale ?>" data-direction="to">
<?php } ?>
<?= empty($language_translation->$message) ? '—' : nl2br(htmlentities($language_translation->$message, ENT_COMPAT, "UTF-8")) ?>
</div>
