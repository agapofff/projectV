<?php

namespace app\entities\contacts;

use Yii;

/**
 * @property string alias
 * @property string country_id
 * @property string country
 * @property string city
 * @property string title
 * @property string subtitle
 * @property string address
 * @property string index
 * @property string phone
 * @property string whatsapp
 * @property string opening_hours
 * @property string email
 * @property string map
 */
class Contact
{
    public $alias;
    public $country_id;
    public $country;
    public $city;
    public $title;
    public $subtitle;
    public $address;
    public $index;
    public $phone;
    public $whatsapp;
    public $opening_hours;
    public $email;
    public $map;

    public function __construct($alias)
    {
        if (isset($this->getData()[$alias])) {
            $data = $this->getData()[$alias];
            $this->alias = $alias;
            $this->country_id = $data['country_id'];
            $this->country = $data['country'];
            $this->city = $data['city'];
            $this->address = $data['address'];
            $this->phone = $data['phone'];
            $this->whatsapp = $data['whatsapp'];
            $this->opening_hours = $data['opening_hours'];
            $this->email = $data['email'];
            $this->map = $data['map'];
        }
    }

    public function getLink()
    {
        return ['/contacts/contacts/index', 'alias' => $this->alias];
    }

    public function getPath()
    {
        return '@web/storage/contacts/contacts/';
    }

    ####################################################################################################################

    public static function getData()
    {
        return [
            'austria-vienna' => [
                'country_id' => 3,
                'country' => Yii::t('app', 'Австрия'),
                'city' => Yii::t('app', 'Вена'),
                'address' => Yii::t('admin', 'Siebenbrunnengasse 46/2/40, 1050 Vienna'),
                'email' => 'office.vienna@freedomgroupint.com',
                'phone' => '+43 681 10776076',
                'whatsapp' => null,
                'opening_hours' => Yii::t('admin', '{weekdays} 08:00 - 17:00', ['weekdays' => Yii::t('app', 'пн-чт')]) . ', ' . Yii::t('admin', '{weekdays} 8:00 - 15:30', ['weekdays' => Yii::t('app', 'пт')]),
                'map' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2658.7677661030893!2d16.37385551588661!3d48.211088954016525!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x476d07a1b625eecb%3A0x45cc09ab0eae7e23!2zRmxlaXNjaG1hcmt0IDEsIDEwMTAgV2llbiwg0JDQstGB0YLRgNC40Y8!5e0!3m2!1s{iso_language}!2s{iso_country}!4v1624214132405!5m2!1s{iso_language}!2s{iso_country}',
                'date_created' => '2020-06-20 00:00:00',
                'date_updated' => '2022-05-17 10:00:00',
            ],
            'rf-moscow' => Yii::$app->params['currency'] === 'RUB' ? [
                'country_id' => 1,
                'country' => Yii::t('app', 'Россия'),
                'city' => Yii::t('app', 'Москва'),
                'address' => Yii::t('app', 'г. Москва, Новинский б-р 18, стр. 1'),
                'email' => Yii::$app->params['email-info'],
                'phone' => '+7 (495) 215-27-27',
                'whatsapp' => null,
                'opening_hours' => Yii::t('admin', '{weekdays} 10:00 — 21:00', ['weekdays' => Yii::t('app', 'пн-вс')]),
                'map' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2245.205171862883!2d37.58452200000001!3d55.754937999999996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46b54a4aa42703af%3A0xdc857d3b9ddad23!2z0J3QvtCy0LjQvdGB0LrQuNC5INCx0YPQuy4sIDE4INGB0YIgMSwg0JzQvtGB0LrQstCwLCAxMjEwNjk!5e0!3m2!1s{iso_language}!2s{iso_country}!4v1652291000996!5m2!1s{iso_language}!2s{iso_country}',
                'date_created' => '2020-06-20 00:00:00',
                'date_updated' => '2022-05-17 10:00:00',
            ] : null,
            'rf-spb' => Yii::$app->params['currency'] === 'RUB' ? [
                'country_id' => 1,
                'country' => Yii::t('app', 'Россия'),
                'city' => Yii::t('app', 'Санкт-Петербург'),
                'address' => Yii::t('app', 'Санкт-Петербург, пл. Александра Невского д.2 литера Е (Торговый центр "Москва")'),
                'email' => Yii::$app->params['email-info'],
                'phone' => '+7 (952) 262-19-19',
                'whatsapp' => null,
                'opening_hours' => Yii::t('admin', '{weekdays} 10:00 — 21:00', ['weekdays' => Yii::t('app', 'пн-вс')]),
                'map' => 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7997.716995903462!2d30.3871941!3d59.9250192!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xcd97195c986ceca7!2z0JHQuNC30L3QtdGBLdGG0LXQvdGC0YAgItCc0L7RgdC60LLQsCI!5e0!3m2!1s{iso_language}!2s{iso_country}!4v1652796499095!5m2!1s{iso_language}!2s{iso_country}',
                'date_created' => '2020-06-20 00:00:00',
                'date_updated' => '2022-05-17 10:00:00',
            ] : null,
            'armenia-yerevan' => [
                'country_id' => 1,
                'country' => Yii::t('app', 'Армения'),
                'city' => Yii::t('app', 'Ереван'),
                'address' => Yii::t('app', 'Ереван, ул.Никогайос Тигранян, д. 7'),
                'email' => Yii::$app->params['email-info'],
                'phone' => '+374-91-306-521',
                'whatsapp' => null,
                'opening_hours' => Yii::t('admin', '{weekdays} 10:00 — 18:00', ['weekdays' => Yii::t('app', 'пн-пт')]) . ', ' . Yii::t('admin', '{weekdays} 10:00 — 14:00', ['weekdays' => Yii::t('app', 'сб')]),
                'map' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3047.139449422209!2d44.517818515637636!3d40.20596087939024!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x406abd340df89b09%3A0x8c8b18df2860b811!2zNyBOaWtvZ2hheW9zIFRpZ3JhbnlhbiBTdCwgWWVyZXZhbiAwMDE0LCDQkNGA0LzQtdC90LjRjw!5e0!3m2!1s{iso_language}!2s{iso_country}!4v1652796499095!5m2!1s{iso_language}!2s{iso_country}',
                'date_created' => '2020-06-20 00:00:00',
                'date_updated' => '2022-05-17 10:00:00',
            ],
            'honk_kong' => [
                'country_id' => 4,
                'country' => Yii::t('app', 'Гонконг'),
                'city' => Yii::t('app', 'Гонконг'),
                'address' => Yii::t('app', 'Гонконг, New Trade Plaza 6 on Ping Street Shatin, Башня A, 604'),
                'email' => Yii::$app->params['email-info'],
                'phone' => null,
                'whatsapp' => null,
                'opening_hours' => Yii::t('admin', '{weekdays} 10:00 — 19:00', ['weekdays' => Yii::t('app', 'пн-пт')]),
                'map' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3689.018904898236!2d114.20518951541631!3d22.390644745266506!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x340406471228bbc7%3A0x2611f10f25c8eb38!2sNew%20Trade%20Plaza!5e0!3m2!1s{iso_language}!2s{iso_country}!4v1624214168748!5m2!1s{iso_language}!2s{iso_country}',
                'date_created' => '2020-06-20 00:00:00',
                'date_updated' => '2022-05-17 10:00:00',
            ],
            'vietnam-minh_city' => [
                'country_id' => 1055,
                'country' => Yii::t('app', 'Вьетнам'),
                'city' => Yii::t('app', 'Хошимин'),
                'address' => Yii::t('admin', 'Khu thương mại HaDo Centrosa Garden, 200 Đường 3/2, Phường 12, Quận 10, Tp.HCM'),
                'email' => 'infovietnam@freedomgroupint.com',
                'phone' => '+84 77 262 94 07',
                'whatsapp' => null,
                'opening_hours' => Yii::t('admin', '{weekdays} 09:00 — 18:00', ['weekdays' => Yii::t('app', 'пн-сб')]),
                'map' => 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14398.51758761128!2d106.67544481434537!3d10.780365187685025!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x20a366fcc02687de!2sHa%20Do%20Centrosa%20Garden!5e0!3m2!1s{iso_language}!2s{iso_country}!4v1649156285529!5m2!1s{iso_language}!2s{iso_country}',
                'date_created' => '2020-06-20 00:00:00',
                'date_updated' => '2022-05-17 10:00:00',
            ],
            'kazakhstan' => [
                'country_id' => 5,
                'country' => Yii::t('app', 'Казахстан'),
                'city' => Yii::t('app', 'Алматы'),
                'address' => Yii::t('app', 'ул. Толе Би, д. 73А, первый этаж, 103 каб'),
                'email' => Yii::$app->params['email-info'],
                'phone' => '+7 727 339 66 16',
                'whatsapp' => '+7 747 277 70 71',
                'opening_hours' =>  Yii::t('admin', '{weekdays} 10:00 — 21:00', ['weekdays' => Yii::t('app', 'пн-пт')]) . ', ' . Yii::t('admin', '{weekdays} 11:00 — 20:00', ['weekdays' => Yii::t('app', 'сб-вс')]),
                'map' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2905.8434746095054!2d76.93237761571726!3d43.254702179137006!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38836eb94490605f%3A0xbf247d463f3dae0b!2z0YPQu9C40YbQsCDQotC-0LvQtSDQkdC4IDczLCDQkNC70LzQsNGC0YsgMDUwMDAwLCDQmtCw0LfQsNGF0YHRgtCw0L0!5e0!3m2!1s{iso_language}!2s{iso_country}!4v1642765021981!5m2!1s{iso_language}!2s{iso_country}',
                'date_created' => '2020-06-20 00:00:00',
                'date_updated' => '2022-05-17 10:00:00',
            ],
            'uzbekistan' => [
                'country_id' => 5,
                'country' => Yii::t('app', 'Узбекистан'),
                'city' => Yii::t('app', 'Ташкент'),
                'address' => Yii::t('app', 'Чиланзарский район, ул. Мукими, д. 21, ст.метро «Новза»'),
                'email' => Yii::$app->params['email-info'],
                'phone' => '+998 71 231 72 14',
                'whatsapp' => null,
                'opening_hours' => Yii::t('admin', '{weekdays} 09:00 - 20:00', ['weekdays' => Yii::t('app', 'пн-пт')]) . ', ' . Yii::t('admin', '{weekdays} 10:00 - 20:00', ['weekdays' => Yii::t('app', 'сб-вс')]),
                'map' => 'https://yandex.com/map-widget/v1/-/CCUJMZF90C',
                'date_created' => '2020-06-20 00:00:00',
                'date_updated' => '2022-05-17 10:00:00',
            ],
            'ukraine' => [
                'country_id' => 2,
                'country' => Yii::t('app', 'Украина'),
                'city' => Yii::t('app', 'Киев'),
                'address' => Yii::t('admin', 'вул. Велика Васильківська, 82'),
                'email' => 'officeukraine@freedomgroupint.com',
                'phone' => '+38 067 150-25-73',
                'whatsapp' => null,
                'opening_hours' => Yii::t('admin', '{weekdays} 10:00 - 18:00', ['weekdays' => Yii::t('app', 'пн-пт')]),
                'map' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d40526.60329848739!2d30.50470404120283!3d50.428736156566806!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40d4cf1d7b91087d%3A0x72763f64e9ab7ecc!2z0JHQvtC70YzRiNCw0Y8g0JLQsNGB0LjQu9GM0LrQvtCy0YHQutCw0Y8sIDgyLCDQmtC40LXQsiwg0KPQutGA0LDQuNC90LAsIDAyMDAw!5e0!3m2!1sru!2sby!4v1674677083403!5m2!1suk!2suk',
                'date_created' => '2023-01-25 00:00:00',
                'date_updated' => '2023-01-26 10:00:00',
            ],
        ];
    }

    public function getMap(string $locale)
    {
        $explode = explode('-', strtolower($locale));

        return
            str_replace('{iso_language}', $explode[0],
                str_replace('{iso_country}', $explode[1],
                    $this->map));
    }
}
