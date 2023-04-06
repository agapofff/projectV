<?php

use yii\helpers\Url;

$translationLink = Url::to(['/admin/lang/translations/'], true);

?>
Здравствуйте,

Появились новые строки, которые необходимо перевести.

<?= $rowsInfo ?>

<?= $translationLink ?>
