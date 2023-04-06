<?php

namespace app\repositories;

use app\entities\contacts\Contact;

class ContactRepository
{
    public function getByUrl($alias)
    {
        return new Contact($alias);
    }

    public function getByCountryId($country_id)
    {
        foreach (array_filter(Contact::getData()) as $key => $val) {
            if ($val['country_id'] === $country_id) {
                $model = new Contact($key);
                break;
            }
        }

        if (!isset($model)) {
            $model = new Contact('austria-vienna');
        }

        return $model;
    }

    public function getAll()
    {
        $arr = [];
        foreach (array_filter(Contact::getData()) as $key => $val) {
            $arr[$key] = new Contact($key);
        }
        return $arr;
    }

    public function getPrev($key)
    {
        $array = array_filter(Contact::getData());

        $keys = array_keys($array);
        $found_index = array_search($key, $keys);

        if ($found_index === false || $found_index === 0) {
            return false;
        }

        $alias = $keys[$found_index - 1];

        return $this->getByUrl($alias);
    }

    public function getNext($key)
    {
        $array = array_filter(Contact::getData());

        $keys = array_keys($array);
        $found_index = array_search($key, $keys);

        if ($found_index === false || $found_index === count($array) - 1) {
            return false;
        }

        $alias = $keys[$found_index + 1];

        return $this->getByUrl($alias);
    }
}
