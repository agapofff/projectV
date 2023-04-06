<?php

use yii\helpers\Html;
use yii\web\View;

?>

<div class="wlang langs">
    <div class="lang <?= $current->local ?>">
        <span class="name" onclick="showLangs()"><?= $current->name ?></span>
    </div>
    <ul>
    <?php foreach ($langs as $lang) { ?>
        <li><?= Html::a($lang->name, '/'.$lang->url.Yii::$app->getRequest()->getLangUrl(), [
            'class' => 'lang '.$lang->local,
            'id' => 'langs',
        ]) ?></li>
    <?php } ?>
    </ul>
</div>

<?php
$script = "
$(document).on('click', '.wlang.langs div.lang', function(event) {
    $('.wlang.langs ul').toggle();
});
// Убираем окошко при клике в любом месте экрана вне окошка
$(document).click( function(event){
    if( $(event.target).closest('.wlang.langs').length ) 
        return;
    $('.wlang.langs ul').fadeOut(200);
    event.stopPropagation();
});
";

$this->registerJs($script, View::POS_READY);
