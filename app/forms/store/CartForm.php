<?php

namespace app\forms\store;

use app\entities\store\Order;
use app\repositories\CountryRepository;
use app\services\store\SessiaService;
use Yii;
use yii\base\Model;

/**
 * @property int client_id
 *
 * @property string country_name
 * @property int country_id
 * @property string city_name
 * @property int city_id
 *
 * @property string name
 * @property string email
 * @property string phone
 * @property string phone_mask
 *
 * @property string delivery_type
 * @property int delivery_id
 * @property float price_delivery
 *
 * @property string post_code
 * @property string street
 * @property string home_number
 * @property string room
 *
 * @property string promo_code
 */
class CartForm extends Model
{
    public $client_id;

    public $country_name;
    public $country_id;
    public $city_name;
    public $city_id;

    public $name;
    public $email;
    public $phone;
    public $phone_code;
    public $phone_mask;

    public $delivery_type;
    public $delivery_id;
    public $price_delivery;

    public $post_code;
    public $street;
    public $home_number;
    public $room;

    public $promo_code;

    public function __construct(Order $order = null, $config = [])
    {
        if ($order) {
            if ($client = $order->client) {

                $this->country_id = 0;
                $countryRepository = new CountryRepository();
                if ($country = $countryRepository->get(Yii::$app->params['country_id'])) {
                    $this->country_id = $country->id;
                    $this->country_name = $country->getLocalTitle();
                    $this->phone_code = $country->phone_code;
                    $this->phone_mask = $country->phone_mask;
                }

                $this->city_id = 0;
                $sessiaService = new SessiaService();
                if (!empty($client->city_id)) {
                    $cities = $sessiaService->getCities(
                        Yii::$app->params['country_id'],
                        Yii::$app->params['lang_id'],
                        0,
                        ''
                    );
                    foreach ($cities as $city) {
                        if ($city->id === $client->city_id) {
                            $this->city_id = $city->id;
                            $this->city_name = $city->name;
                            break;
                        }
                    }
                }

                $this->name = $client->name;
                $this->email = $client->email;
                $this->phone = $client->phone;

                $this->delivery_type = $order->delivery_type;
                $this->delivery_id = $order->delivery_id;
                $this->price_delivery = $order->price_delivery;

                $this->post_code = $client->post_code;
                $this->street = $client->street;
                $this->home_number = $client->home_number;
                $this->room = $client->room;

                $this->promo_code = $order->promo_code;
            }
        }
        parent::__construct($config);
    }

    public function attributeLabels(): array
    {
        return [
            'country_name' => Yii::t('app', 'Страна'),
            'country_id' => Yii::t('app', 'Страна'),
            'city_name' => Yii::t('app', 'Город'),
            'city_id' => Yii::t('app', 'Город'),
            'name' => Yii::t('app', 'Имя Фамилия'),
            'email' => Yii::t('admin', 'Email'),
            'phone' => Yii::t('app', 'Телефон'),
            'post_code' => Yii::t('app', 'Индекс'),
            'street' => Yii::t('app', 'Улица'),
            'home_number' => Yii::t('app', 'Дом'),
            'room' => Yii::t('app', 'Квартира'),
            'promo_code' => Yii::t('app', 'Промокод'),
        ];
    }

    public function rules(): array
    {
        return [
            //[['name', 'email', 'phone', 'delivery_type', 'street', 'home_number', 'room'], 'string'],
            //[['country_id', 'city_id', 'delivery_id', 'price_delivery'], 'integer'],
            [['country_id', 'city_id', 'name', 'email', 'phone', 'post_code', 'street', 'home_number', 'room', 'delivery_type', 'delivery_id', 'price_delivery', 'promo_code'], 'safe'],
        ];
    }
}
