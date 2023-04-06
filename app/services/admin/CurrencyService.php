<?php

namespace app\services\admin;

use app\entities\admin\Currency;
use app\repositories\CurrencyRepository;
use app\repositories\StoreRepository;

class CurrencyService
{
    private $sessiaService;
    private $currencyRepository;
    private $storeRepository;

    public function __construct(
        SessiaService $sessiaService,
        CurrencyRepository $currencyRepository,
        StoreRepository $storeRepository
    )
    {
        $this->sessiaService = $sessiaService;
        $this->currencyRepository = $currencyRepository;
        $this->storeRepository = $storeRepository;
    }

    public function import()
    {
        if ($currencies = $this->sessiaService->getCurrencies()) {

            if ($stores = $this->storeRepository->getAllCurrencyIso()) {
                foreach ($stores as $store) {

                    if ($currency_key = array_search($store->currency_iso, array_column($currencies, 'iso'))) {
                        $currency = $currencies[$currency_key];

                        if ($currency_model = $this->currencyRepository->get($currency['id'])) {
                            $currency_model->edit(
                                $currency['iso'],
                                $currency['roundScale']
                            );
                        } else {
                            $currency_model = Currency::create(
                                $currency['id'],
                                $currency['iso'],
                                $currency['roundScale']
                            );
                        }
                        $this->currencyRepository->save($currency_model);
                    }
                }
            }
        }
    }
}
