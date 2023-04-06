<?php

use yii\helpers\Url;

?>

<section class="c16-1 c-section">
    <div class="container">
        <div class="row">
            <div class="col-xxl-6 offset-xxl-3 col-lg-8 offset-lg-2">
                <div class="c16-1__title c-fz3 c-mb1">
                    <?= Yii::t('app', 'Родиной вишни традиционно считается территория древней Персии (сейчас это Иран), однако некоторые исторические свидетельства указывают на&nbsp;то, что вишня росла ещё и&nbsp;в&nbsp;районе Кавказа') ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xxl-6 offset-xxl-3 col-lg-8 offset-lg-2">
                <div class="c16-1__img c-img c-img-contain" style="background-image: url(<?= Url::to($url . 'c16-1.png?v=1') ?>);"></div>
            </div>
        </div>
    </div>
</section>

<section class="c16-2 c-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 offset-lg-1">
                <div class="c16-2__title c-fz2 c-mb2" data-aos="slide-up">
                    <?= Yii::t('app', 'Останавливая время') ?>
                </div>
                <div class="row">
                    <div class="col-lg-10">
                        <div class="c16-2__text c-fz5 c-mb1" data-aos="slide-up">
                            <?= Yii::t('app', 'Химические элементы цинк, медь и&nbsp;магний не&nbsp;синтезируются в&nbsp;организме, а&nbsp;поступают извне с&nbsp;пищей, воздухом, через кожу и&nbsp;слизистые. {s}Глюконат{e} и&nbsp;{s}аспартат{e}&nbsp;&mdash; это органические формы солей, которые организм способен легко усваивать.', ['s' => '<b>', 'e' => '</b>']) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 c-img-bg">
                <div class="c16-2__img c-img c-mb1" data-aos="fade" style="background-image: url(<?= Url::to($url . 'c16-2_1.jpg?v=1') ?>);"></div>
                <div class="c16-2__text c-fz5 c-mb1" data-aos="slide-up">
                    <?= Yii::t('app', 'Активные компоненты Sepitonic&nbsp;&mdash; аспартат магния, глюконат цинка, глюконат меди&nbsp;&mdash; это комбинация минералов, они помогают приостановить наступление процессов старения, которые могут начаться даже в&nbsp;достаточно молодом возрасте. Благодаря им&nbsp;Sepitonic усиливает энергетический баланс клеток, обеспечивает мощную антиоксидантную защиту и&nbsp;укрепляет межклеточные связи в&nbsp;коже, поддерживает её&nbsp;упругость и&nbsp;эластичность, формирует нормальный тургор&nbsp;&mdash; возвращает гладкость и&nbsp;молодость кожи.') ?>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="c16-2__img c-img" data-aos="fade" style="background-image: url(<?= Url::to($url . 'c16-2_2.jpg?v=1') ?>);"></div>
            </div>
        </div>
    </div>
</section>

<section class="c16-3 c-section c-img c-img-panorama" data-aos="fade" style="background-image: url(<?= Url::to($url . 'c16-3.jpg?v=1') ?>);"></section>

<section class="c16-4 c-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 offset-lg-1">
                <div class="c16-4__title c-fz2 c-mb2" data-aos="slide-up">
                    <?= Yii::t('app', 'Синергия молодости') ?>
                </div>
                <div class="c16-4__text c-fz5 c-mb1" data-aos="slide-up">
                    <?= Yii::t('app', 'Компоненты Sepitonic подобраны таким образом, что могут усиливать эффект друг друга.') ?>
                </div>
                <div class="c16-4__img-1 c-img c-mb1" data-aos="fade" style="background-image: url(<?= Url::to($url . 'c16-4_1.jpg?v=1') ?>);"></div>
            </div>
            <div class="col-lg-6 offset-lg-1">
                <div class="c16-4__img-2 c-img c-mb1" data-aos="fade" style="background-image: url(<?= Url::to($url . 'c16-4_2.jpg?v=1') ?>);"></div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="c16-4__text c-fz5 c-mb2" data-aos="slide-up">
                            <?= Yii::t('app', '{s}Магний{e} участвует в&nbsp;синтезе белков и&nbsp;гиалуроновой кислоты кожи и&nbsp;обеспечивает прочность матрикса.', ['s' => '<b>', 'e' => '</b>']) ?>
                            <br><br>
                            <?= Yii::t('app', '{s}Медь{e} стимулирует клеточное дыхание, способствует синтезу кератина и&nbsp;коллагена, образует поперечные дисульфидные связи, не&nbsp;дающие коже провисать.', ['s' => '<b>', 'e' => '</b>']) ?>
                            <br><br>
                            <?= Yii::t('app', '{s}Цинк{e} оказывает антисептическое действие и&nbsp;противовоспалительный эффект. Он&nbsp;стимулирует синтез ДНК. Таким образом, Sepitonic работает хронологически на&nbsp;каждом этапе энергетического каскада, благотворно влияя на&nbsp;производство энергетических медиаторов, нормализует жировой баланс.', ['s' => '<b>', 'e' => '</b>']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
