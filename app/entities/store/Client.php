<?php

namespace app\entities\store;

use app\entities\store\Order;
use Yii;
use yii\db\ActiveRecord;

/**
 * @property integer id
 *
 * @property string hash
 *
 * @property integer country_id
 * @property integer city_id
 *
 * @property string name
 * @property string email
 * @property string phone
 *
 * @property string post_code
 * @property string street
 * @property string home_number
 * @property string room
 *
 * @property string created_at
 * @property string updated_at
 */
class Client extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%clients}}';
    }

    ####################################################################################################################

    public function getOrder()
    {
        return $this->hasOne(Order::class, ['client_id' => 'id'])
            ->where(['currency' => Yii::$app->params['currency'], 'status' => 'new']);
    }

    ####################################################################################################################

    public static function create(): self
    {
        $model = new self();
        $model->hash = md5(time() . 'PV');

        return $model;
    }

    public function edit(
        $country_id,
        $city_id,
        $name,
        $email,
        $phone,
        $post_code,
        $street,
        $home_number,
        $room
    ): void
    {
        $this->country_id = $country_id;
        $this->city_id = $city_id;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->post_code = $post_code;
        $this->street = $street;
        $this->home_number = $home_number;
        $this->room = $room;
    }

    public function getPhone()
    {
        return str_replace([' ', '(', ')', '-'], '', $this->phone);
    }

    public function getCountryCode()
    {
        return str_replace('+', '', explode(' ', $this->phone)[0]) ?? 1;
    }
}
