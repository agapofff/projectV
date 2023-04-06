<?php

namespace app\services\lang;

use app\entities\lang\LangInCountry;
use app\repositories\LangInCountryRepository;

class LangInCountryService
{
    private $langInCountryRepository;

    public function __construct(
        LangInCountryRepository $langInCountryRepository
    )
    {
        $this->langInCountryRepository = $langInCountryRepository;
    }

    #################################################################

    public function create($lang_id, $country_id)
    {
        $langInCountry = LangInCountry::create($lang_id, $country_id);
        return $this->langInCountryRepository->save($langInCountry);
    }

    public function updatePosition($items)
    {
        $i = 0;
        while (isset($items[$i])) {
            $id = (int)$items[$i];
            $position = $i;
            $this->langInCountryRepository->updatePosition($id, $position);
            $i++;
        }
    }

    public function remove($id)
    {
        $langInCountry = $this->langInCountryRepository->get((int)$id);
        $this->langInCountryRepository->remove($langInCountry);
    }
}
