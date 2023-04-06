<?php

use yii\helpers\Url;

$translationLink = Url::to(['/lang/default/translations/'], true);

?>
Здравствуйте,

Появились новые строки, которые необходимо перевести.

<?= $rowsInfo ?>

<?= $translationLink ?>
