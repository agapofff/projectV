<?php

use yii\helpers\Url;

?>

<div class="production usual-page">
    <div class="container">
        <div class="production__main">
            <div class="row">
                <div class="col-xxl-6 col-lg-7">
                    <h1 class="production__title fz1"><?= Yii::t('admin', 'Made in France') ?></h1>
                    <div class="production__subtitle fz3"><?= Yii::t('app', '27&nbsp;лет в&nbsp;разработке и&nbsp;производстве натуральных нутрицевтиков') ?></div>
                    <div class="row">
                        <div class="col-lg-10">
                            <div class="production__text"><?= Yii::t('app', 'Для создания инновационных продуктов Project V&nbsp;мы выбрали предприятие с&nbsp;передовым научно-техническим потенциалом, способное обеспечить эксклюзивное качество. Основанное в&nbsp;1996&nbsp;году, сегодня оно входит в&nbsp;топ-5 французской фармацевтической индустрии и&nbsp;каждая его новая разработка отражает идею создателей&nbsp;&mdash; предоставлять лучшие продукты для здоровья и&nbsp;повышать качество жизни. Для их&nbsp;производства используются только новейшие технологии, позволяющие сохранять максимум полезных свойств компонентов.') ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-6 col-lg-5">
                    <div class="production__img" style="background-image: url(' <?= Url::to('@web/storage/about/production/main.png?v=1') ?> ');"></div>
                </div>
            </div>
        </div>

        <?php
        $arr = [
            (object) [
                'title' => Yii::t('app', 'Натуральные {br}компоненты', ['br' => '<br>']),
                'text' => Yii::t('app', 'Вся продукция Project V&nbsp;изготавливается из&nbsp;высококачественного природного сырья европейского производства'),
            ],
            (object) [
                'title' => Yii::t('app', 'Французское {br}качество', ['br' => '<br>']),
                'text' => Yii::t('app', 'Производство соответствует стандарту GMP, все продукты имеют необходимые сертификаты качества'),
            ],
            (object) [
                'title' => Yii::t('app', 'Инновационные {br}технологии', ['br' => '<br>']),
                'text' => Yii::t('app', 'Криодробление (t&nbsp;до &mdash;196&deg;) помогает сохранить в&nbsp;экстракте оптимальный объем активных ингредиентов'),
            ],
            (object) [
                'title' => Yii::t('app', 'Научные {br}исследования', ['br' => '<br>']),
                'text' => Yii::t('app', 'Более 2&nbsp;000 уникальных разработок создано в&nbsp;лабораториях предприятия ведущими европейскими учеными'),
            ],
        ];
        ?>
        <div class="production__items">
            <div class="row">
                <?php foreach ($arr as $key => $val) { ?>
                <div class="col-lg-3 col-md-6">
                    <div class="production__item production-item">
                        <div class="production-item__img" style="background-image: url(' <?= Url::to('@web/storage/about/production/item-0' . ++$key . '.jpg?v=1') ?> ');"></div>
                        <h3 class="production-item__title fz4"><?= $val->title ?></h3>
                        <div class="production-item__text"><?= $val->text ?></div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>

        <?php
        $arr = [
            (object) [
                'title' => Yii::t('admin', 'GMP'),
                'text' => Yii::t('app', 'Мировой эталон качества {br}производственной практики', ['br' => '']),
            ],
            (object) [
                'title' => Yii::t('admin', 'HACCP'),
                'text' => Yii::t('app', 'Международная система безопасности пищевой продукции'),
            ],
            (object) [
                'title' => Yii::t('admin', 'ISO 9001'),
                'text' => Yii::t('app', 'Международная система {br}менеджмента качества', ['br' => '']),
            ],
            (object) [
                'title' => Yii::t('admin', 'ISO 22000'),
                'text' => Yii::t('app', 'Система контроля качества пищевой продукции'),
            ],
            (object) [
                'title' => Yii::t('admin', 'Без ГМО'),
                'text' => Yii::t('app', 'Не содержит генномодифицированных продуктов'),
            ],
            (object) [
                'title' => Yii::t('admin', 'Халяль'),
                'text' => Yii::t('app', 'Продукция соответствует принятым в&nbsp;исламе канонам'),
            ],
            (object) [
                'title' => Yii::t('admin', 'Ecocert'),
                'text' => Yii::t('app', 'Гарантирует натуральное происхождение и&nbsp;экологическую чистоту продукции'),
            ],
            (object) [
                'title' => Yii::t('admin', 'Agriculture Biologique'),
                'text' => Yii::t('app', 'Продукты содержат более&nbsp;95% органических компонентов'),
            ],
        ];
        ?>
        <div class="production__items">
            <div class="production__row">
                <?php foreach ($arr as $key => $val) { ?>
                    <div class="production__col">
                        <div class="production__item production-item">
                            <div class="production-item__svg" style="background-image: url(' <?= Url::to('@web/storage/about/production/item-0' . ++$key . '.svg?v=1') ?> ');"></div>
                            <h3 class="production-item__title fz4"><?= $val->title ?></h3>
                            <div class="production-item__text fz5"><?= $val->text ?></div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="production__middle">
            <div class="row">
                <div class="col-xxl-6 col-lg-4">
                    <div class="production__img" style="background-image: url(' <?= Url::to('@web/storage/about/production/img.png?v=1') ?> ');"></div>
                </div>
                <div class="col-xxl-5 offset-xxl-1 col-lg-7 offset-lg-1">
                    <h1 class="production__title fz1"><?= Yii::t('admin', 'Made in Switzerland') ?></h1>
                    <div class="production__subtitle fz3"><?= Yii::t('app', 'Более 50&nbsp;лет опыта создания космецевтики премиум-класса') ?></div>
                    <div class="row">
                        <div class="col-lg-10">
                            <div class="production__text"><?= Yii::t('app', 'Швейцария&nbsp;&mdash; подлинный бриллиант индустрии красоты, эта страна занимает лидирующие позиции в&nbsp;области профессиональных косметических продуктов. Для производства инновационной космецевтики Project V&nbsp;мы выбрали швейцарские предприятия, которые являются признанными экспертами в&nbsp;разработке медицинских и&nbsp;косметических формул на&nbsp;основе последних научных достижений и&nbsp;длительное время сотрудничают со&nbsp;всемирно известными брендами, крупными косметическими компаниями и&nbsp;медицинскими клиниками.') ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        $arr = [
            (object) [
                'title' => Yii::t('app', 'Талая ледниковая {br}вода', ['br' => '<br>']),
                'text' => Yii::t('app', 'Уникальный природный актив, который добывается из&nbsp;высокогорных ледников в&nbsp;Швейцарских Альпах'),
            ],
            (object) [
                'title' => Yii::t('app', 'Швейцарское {br}качество', ['br' => '<br>']),
                'text' => Yii::t('app', 'Международные сертификаты, признанные контролирующими органами большинства стран мира'),
            ],
            (object) [
                'title' => Yii::t('app', 'Оригинальные {br}формулы', ['br' => '<br>']),
                'text' => Yii::t('app', 'Разработаны с&nbsp;участием косметологов, дерматологов и&nbsp;нейробиологов мирового уровня'),
            ],
            (object) [
                'title' => Yii::t('app', 'Клинические {br}исследования', ['br' => '<br>']),
                'text' => Yii::t('app', 'Подтверждают высокое качество и&nbsp;безопасность дермацевтических компонентов косметики Project&nbsp;V'),
            ],
        ];
        ?>
        <div class="production__items">
            <div class="row">
                <?php foreach ($arr as $key => $val) { ?>
                <div class="col-lg-3 col-md-6">
                    <div class="production__item production-item">
                        <div class="production-item__img" style="background-image: url(' <?= Url::to('@web/storage/about/production/item-1' . ++$key . '.jpg?v=1') ?> ');"></div>
                        <h3 class="production-item__title fz4"><?= $val->title ?></h3>
                        <div class="production-item__text"><?= $val->text ?></div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>

        <?php
        $arr = [
            (object) [
                'title' => Yii::t('admin', 'GMP'),
                'text' => Yii::t('app', 'Мировой эталон качества {br}производственной практики', ['br' => '<br>']),
            ],
            (object) [
                'title' => Yii::t('admin', 'ISO 9001'),
                'text' => Yii::t('app', 'Международная система {br}менеджмента качества', ['br' => '<br>']),
            ],
            (object) [
                'img' => '',
                'title' => Yii::t('admin', 'Tested by dermatologist'),
                'text' => Yii::t('app', 'Разработаны с&nbsp;участием косметологов, дерматологов и&nbsp;нейробиологов мирового уровня'),
            ],
            (object) [
                'title' => Yii::t('admin', 'Not tested on animals'),
                'text' => Yii::t('app', 'Не&nbsp;тестировано {br}на&nbsp;животных', ['br' => '<br>']),
            ],
        ];
        ?>
        <div class="production__items">
            <div class="row">
                <?php foreach ($arr as $key => $val) { ?>
                <div class="col-lg-3 col-6">
                    <div class="production__item production-item">
                        <div class="production-item__svg" style="background-image: url(' <?= Url::to('@web/storage/about/production/item-1' . ++$key . '.svg?v=1') ?> ');"></div>
                        <h3 class="production-item__title fz4"><?= $val->title ?></h3>
                        <div class="production-item__text"><?= $val->text ?></div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
