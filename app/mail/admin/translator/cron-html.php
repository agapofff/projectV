<?php

use yii\helpers\Html;
use yii\helpers\Url;

$translationLink = Url::to(['/admin/lang/translations/'], true);

?>

<p>Здравствуйте,</p>
<p>Появились новые строки, которые необходимо перевести.</p>
<p><?= $rowsInfo ?></p>
<p><?= Html::a(Yii::t('app', 'Перейти в панель перевода'), $translationLink) ?></p>
