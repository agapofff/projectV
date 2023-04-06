<?php

namespace app\repositories;

use app\entities\contacts\Delivery;

class DeliveryRepository
{
    public function get()
    {
        return new Delivery();
    }
}
