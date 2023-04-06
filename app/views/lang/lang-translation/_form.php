<?php

$message = $language_translation->getMessage($locale);

?>

<textarea class="translations-category__form" data-locale="<?= $locale ?>" data-direction="<?= $direction ?>"><?= htmlentities($language_translation->$message, ENT_COMPAT, "UTF-8") ?></textarea>
