<?php

namespace app\services\admin;

use app\entities\admin\Country;
use app\entities\admin\StoreInCountry;
use app\repositories\CountryRepository;
use app\repositories\StoreInCountryRepository;
use app\repositories\StoreRepository;

class CountryService
{
    private $sessiaService;
    private $storeRepository;
    private $countryRepository;
    private $storeInCountryRepository;

    public function __construct(
        SessiaService $sessiaService,
        StoreRepository $storeRepository,
        CountryRepository $countryRepository,
        StoreInCountryRepository $storeInCountryRepository
    )
    {
        $this->sessiaService = $sessiaService;
        $this->storeRepository = $storeRepository;
        $this->countryRepository = $countryRepository;
        $this->storeInCountryRepository = $storeInCountryRepository;
    }

    public function import()
    {
        $this->storeInCountryRepository->deleteAll();
        $this->countryRepository->deactivate();

        $stores = $this->storeRepository->getAll();
        foreach ($stores as $store) {
            $delivery_countries = $this->sessiaService->getDeliveryCountries($store->id);
            foreach ($delivery_countries as $country) {

                if (!$this->storeInCountryRepository->checkRelation($store->id, $country['id'])) {
                    $storeInCountry = StoreInCountry::create(
                        $store->id,
                        $country['id']
                    );
                    $this->storeInCountryRepository->save($storeInCountry);
                }

                if (!$this->countryRepository->get($country['id'])) {
                    $country = Country::create(
                        $country['id'],
                        $country['name'],
                        $country['isoCode'],
                        $country['code'],
                        $country['mask']
                    );
                    $this->countryRepository->save($country);
                } else {
                    $this->countryRepository->updateActive($country['id']);
                }
            }
        }
    }

    public function updateActive($id, $active)
    {
        $country = $this->countryRepository->get((int)$id);
        $country->updateActive(
            $active
        );
        $this->countryRepository->save($country);

        return $country;
    }

    public function edit(
        $id,
        $domain,
        $title,
        $iso,
        $lang_id,
        $languages,
        $store_id,
        $phone_code,
        $phone_mask,
        $post_code
    )
    {
        $country = $this->countryRepository->get($id);
        if (!empty($store_id)) {
            $store = $this->storeRepository->get($store_id);
        }

        $country->edit(
            $domain,
            $title,
            $iso,
            $lang_id,
            $languages,
            $store->currency_iso ?? null,
            $store->id ?? null,
            $phone_code,
            $phone_mask,
            $post_code
        );
        $this->countryRepository->save($country);
    }

    public static function getCountryById($id)
    {
        $countryRepository = new CountryRepository();
        return $countryRepository->get($id);
    }
}
