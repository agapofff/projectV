<?php

use app\entities\admin\Product;
use app\repositories\ContactRepository;
use yii\helpers\Html;

$contactRepository = new ContactRepository();
$contact = $contactRepository->getByCountryId(Yii::$app->params['country_id']);

?>

<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-xxl-4 col-xl-3 footer__about">
                <div class="footer__title fz4"><?= Yii::t('app', 'О нас') ?></div>
                <div class="footer__text">
                    <?= Yii::t('app', 'Project V&nbsp;создает инновационные продукты, которые помогают людям заботиться о&nbsp;красоте и&nbsp;здоровье, жить полноценной жизнью и&nbsp;улучшать ее&nbsp;качество. Project V&nbsp;&mdash; это прекрасный шанс для каждого человека продлить активное долголетие и&nbsp;быть счастливым.') ?>
                </div>
            </div>
            <div class="col-12 footer__contacts-mobile">
                <div class="footer__title fz4"><?= Yii::t('app', 'Контакты') ?></div>
                <div class="footer__contacts">
                    <?php if (preg_match('(EUR)', Yii::$app->params['currency'])) { ?>
                    <div class="footer__contact">
                        Sessia GmbH
                    </div>
                    <?php } ?>
                    <div class="footer__contact">
                        <?= Yii::t('app', 'Адрес: {address}', ['address' => '<span>' . Yii::t('admin', '{address}, {country}', ['address' => $contact->address, 'country' => $contact->country]) . '</span>']) ?>
                    </div>
                    <div class="footer__contact">
                        <?= Yii::t('app', 'Телефон: {phone}', ['phone' => '<span>' . $contact->phone . '</span>']) ?>
                    </div>
                    <div class="footer__contact">
                        <?= Yii::t('app', 'Часы работы: {working_hours}', ['working_hours' => '<span>' . $contact->opening_hours . '</span>']) ?>
                    </div>
                    <div class="footer__contact">
                        <?= Yii::t('admin', 'Email: {email}', ['email' => '<span>' . $contact->email . '</span>']) ?>
                    </div>
                </div>
                <div class="footer__networks footer__networks_mobile">
                    <?= $this->renderFile('@app/views/layouts/_networks.php') ?>
                </div>
            </div>
            <div class="col-xxl-4 offset-xxl-1 col-xl-5 offset-xl-1 col-lg-8">
                <div class="footer__title fz4"><?= Yii::t('app', 'Карта сайта') ?></div>
                <div class="row">
                    <div class="col-6">
                        <div class="footer__menu">
                            <?php foreach (Product::getCategoryList() as $val) { ?>
                            <div class="footem__item">
                                <?= Html::a($val['label'], ['/store/default/catalog', 'category' => $val['url']], ['class' => 'footer__link']) ?>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="footer__menu">
                            <div class="footem__item">
                                <?= Html::a(Yii::t('app', 'Миссия'), ['/about/mission/index'], ['class' => 'footer__link']) ?>
                            </div>
                            <div class="footem__item">
                                <?= Html::a(Yii::t('app', 'Сертификаты'), ['/about/certificates/index'], ['class' => 'footer__link']) ?>
                            </div>
                            <?php /*if (Yii::$app->params['currency'] === 'RUB') { ?>
                            <div class="footem__item">
                                <?= Html::a(Yii::t('app', 'Пресса'), ['/about/post/index', 'type' => 'mass-media'], ['class' => 'footer__link']) ?>
                            </div>
                            <div class="footem__item">
                                <?= Html::a(Yii::t('app', 'Блог'), ['/blog/post/index', 'type' => 'blog'], ['class' => 'footer__link']) ?>
                            </div>
                            <?php }*/ ?>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="footer__menu">
                            <div class="footem__item">
                                <?= Html::a(Yii::t('app', 'Производство'), ['/about/production/index'], ['class' => 'footer__link']) ?>
                            </div>
                        </div>
                        <div class="footer__menu">
                            <div class="footem__item">
                                <?= Html::a(Yii::t('app', 'Контакты'), ['/contacts/contacts/index'], ['class' => 'footer__link']) ?>
                            </div>
                            <?php if (Yii::$app->params['currency'] === 'RUB') { ?>
                                <div class="footem__item">
                                    <?= Html::a(Yii::t('app', 'Как сделать заказ'), ['/contacts/info/index', 'url' => 'how-to-make-an-order'], ['class' => 'footer__link']) ?>
                                </div>
                                <div class="footem__item">
                                    <?= Html::a(Yii::t('app', 'Возврат товара'), ['/contacts/info/index', 'url' => 'return-of-goods'], ['class' => 'footer__link']) ?>
                                </div>
                                <div class="footem__item">
                                    <?= Html::a(Yii::t('app', 'Доставка товара'), ['/contacts/info/index', 'url' => 'delivery-of-goods'], ['class' => 'footer__link']) ?>
                                </div>
                                <div class="footem__item">
                                    <?= Html::a(Yii::t('app', 'Способы оплаты'), ['/contacts/info/index', 'url' => 'payment-methods'], ['class' => 'footer__link']) ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 footer__contacts-desktop">
                <div class="footer__title fz4"><?= Yii::t('app', 'Контакты') ?></div>
                <div class="footer__contacts">
                    <?php if (preg_match('(EUR)', Yii::$app->params['currency'])) { ?>
                    <div class="footer__contact">
                        Sessia GmbH
                    </div>
                    <?php } ?>
                    <div class="footer__contact">
                        <?= Yii::t('app', 'Адрес: {address}', ['address' => '<span>' . Yii::t('admin', '{country}, {address}', ['address' => $contact->address, 'country' => $contact->country]) . '</span>']) ?>
                    </div>
                    <div class="footer__contact">
                        <?= Yii::t('app', 'Телефон: {phone}', ['phone' => '<span>' . $contact->phone . '</span>']) ?>
                    </div>
                    <div class="footer__contact">
                        <?= Yii::t('app', 'Часы работы: {working_hours}', ['working_hours' => '<span>' . $contact->opening_hours . '</span>']) ?>
                    </div>
                    <div class="footer__contact">
                        <?= Yii::t('admin', 'Email: {email}', ['email' => '<span>' . $contact->email . '</span>']) ?>
                    </div>
                </div>
                <div class="footer__networks footer__networks_mobile">
                    <?= $this->renderFile('@app/views/layouts/_networks.php') ?>
                </div>
            </div>
        </div>
        <div class="footer__bottom">
            <div class="row">
                <div class="col-xl-9 col-lg-8">
                    <span class="footer__copyright">© <?= date('Y') ?> Project V</span>
                    <?php if (preg_match('(RUB|UAH)', Yii::$app->params['currency'])) { ?>
                        <?= Html::a(Yii::t('app', 'Политика конфиденциальности'), ['/main/site/privacy'], ['class' => 'footer__privacy']) ?>
                    <?php } ?>
                    <?php if (preg_match('(EUR|UAH)', Yii::$app->params['currency'])) { ?>
                        <?= Html::a(Yii::t('app', 'Правила и условия'), ['/main/site/terms-and-conditions'], ['class' => 'footer__terms-and-conditions']) ?>
                    <?php } ?>
                </div>
                <div class="col-xl-3 col-lg-4">
                    <div class="footer__networks footer__networks_desktop">
                        <?= $this->renderFile('@app/views/layouts/_networks.php') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
