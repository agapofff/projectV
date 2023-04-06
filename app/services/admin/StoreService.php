<?php

namespace app\services\admin;

use app\entities\admin\Store;
use app\repositories\StoreRepository;

class StoreService
{
    private $storeRepository;

    public function __construct(
        StoreRepository $storeRepository
    )
    {
        $this->storeRepository = $storeRepository;
    }

    public function create()
    {
        $store = Store::create();
        return $this->storeRepository->save($store);
    }

    public function edit(
        $idOld,
        $id,
        $type,
        $title,
        $currency_iso
    )
    {
        $store = $this->storeRepository->get($idOld);
        $store->edit(
            $id,
            $type,
            $title,
            $currency_iso
        );
        $this->storeRepository->save($store);
    }

    public function remove($id): void
    {
        $store = $this->storeRepository->get((int)$id);
        $this->storeRepository->remove($store);
    }
}
