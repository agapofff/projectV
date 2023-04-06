<?php

namespace app\forms\store;

use yii\base\Model;

/**
 * @property int id
 * @property string city_name
 * @property int city_id
 * @property string name
 * @property string email
 * @property string phone
 * @property string delivery_type,
 * @property int delivery_id,
 * @property string post_code
 * @property string street
 * @property string home_number
 * @property string room
 */
class OrderForm extends Model
{
    public $id;
    public $hash;
    public $sessia_id;
    public $store_id;
    public $price_delivery;
    public $price_total;
    public $request;
    public $response;
    public $status;

    public $city_name;
    public $city_id;
    public $name;
    public $email;
    public $phone;
    public $delivery_type;
    public $delivery_id;
    public $post_code;
    public $street;
    public $home_number;
    public $room;

    public $created_at;
    public $updated_at;

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['city_name', 'city_id', 'name', 'email', 'phone', 'delivery_type', 'delivery_id', 'post_code', 'street', 'home_number', 'room'], 'safe'],
            [['email'], 'email'],
        ];
    }
}
